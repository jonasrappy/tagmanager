<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Services;

use Doctrine\DBAL\Connection;
use Twig\Environment;

class DataLayerRenderer implements DataLayerRendererInterface
{
    const STRING_VALUES = [
        'item_name',
        'item_id',
        'item_brand',
        'item_category',
    ];

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $variables = [];

    /**
     * @var array
     */
    private $dataLayer = [];

    public function __construct(
        Environment $twig,
        Connection $connection
    ) {
        $this->twig = clone $twig;
        $this->connection = $connection;
    }

    public function renderDataLayer(string $route): DataLayerRendererInterface
    {
        $properties = $this->getChildrenList(null, $route);

        $dataLayer = $this->fillValues($properties);

        dump($dataLayer);


        // 🔥 Final Cleanup Before Rendering
        $dataLayer = str_replace('"free-product-', '"', $dataLayer);

        try {
            $template = $this->twig->createTemplate($dataLayer);

            $dataLayer = $template->render($this->getVariables($route));
            $dataLayer = preg_replace('/[[:cntrl:]]/', '', $dataLayer);
            $dataLayer = json_decode($dataLayer, true);

            if (json_last_error() > 0) {
                throw new \Exception(json_last_error_msg(), 1620985321);
            }

            if (!empty($dataLayer)) {
                array_walk_recursive($dataLayer, [$this, 'castArrayValues']);
            }
        } catch (\Exception $e) {
            $dataLayer = [];
            $dataLayer['default'] = json_encode(['error' => $e->getMessage()]);
        }

        if (!empty($dataLayer['default'])) {
            if (!empty($dataLayer['onEvent']) && !empty($dataLayer['default']['event'])) {
                unset($dataLayer['default']['event']);
            }
            $this->dataLayer[$route]['default'] = json_encode($dataLayer['default']);
        }

        if (!empty($dataLayer['onEvent'])) {
            $dataLayer['onEvent']['event'] = $dataLayer['onEvent']['event'] ?? ucfirst(array_key_first($dataLayer['onEvent'])) . 'Push';
            $this->dataLayer[$route]['onEvent'] = json_encode($dataLayer['onEvent']);
        }

        return $this;
    }


    public function getVariables(string $route): array
    {
        return $this->variables[$route];
    }

    public function setVariables(string $route, $variables): DataLayerRendererInterface
    {
        $this->variables[$route] = $variables;

        return $this;
    }

    public function getDataLayer($route): ?array
    {
        return $this->dataLayer[$route] ?? null;
    }

    public function fillValues(array $dataLayer): string
    {
        // Ensure null values are replaced with empty strings
        array_walk_recursive($dataLayer, function (&$value) {
            if (is_null($value)) {
                $value = '';
            }
        });

        $dataLayer = json_encode($dataLayer, JSON_UNESCAPED_SLASHES);

        $search = [',{"endArrayOf":true}'];
        $replace = ['{% endverbatim %}{% if not loop.last %},{% endif %}{% endfor %}{% verbatim %}'];

        $dataLayer = str_replace($search, $replace, $dataLayer);

        while (preg_match('/({"startArrayOf":".*?"},)/i', $dataLayer, $matches)) {
            foreach ($matches as $match) {
                $foreachObj = json_decode(rtrim($match, ','));
                if ($foreachObj->startArrayOf) {
                    $arguments = explode(' in ', $foreachObj->startArrayOf);
                    $dataLayer = str_replace(
                        $match,
                        '{% endverbatim %}{% for ' . @$arguments[0] . ' in ' . @$arguments[1] . ' %}{% verbatim %}',
                        $dataLayer
                    );
                }
            }
        }

        $dataLayer = '{% verbatim %}' . $dataLayer . '{% endverbatim %}';

        return $dataLayer;
    }

    public function getChildrenList($id = null, $module = null): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->from('wbm_data_layer_properties', 'property');

        if ($id !== null) {
            $qb->where('property.parent_id = :parentId')
                ->setParameter('parentId', $id);
        } else {
            $qb->where('property.parent_id IS NULL');
        }

        $qb->andWhere('property.module = :moduleName');
        $qb->setParameter('moduleName', $module);

        $qb->select(
            [
                'property.name',
                'property.value',
                'property.id',
                'property.child_count',
                'property.on_event',
                'property.event_name',
                'property.parent_id',
            ]
        );
        $properties = $qb->executeQuery()->fetchAllAssociative();

        $namedProperties = [];

        foreach ($properties as $key => &$property) {
            // 🚨 Filter out 'free-product-' entries directly here
            if (isset($property['value']) && strpos($property['value'], 'free-product-') !== false) {
                continue; // Skip these entries entirely
            }

            $root = ($property['parent_id'] === null);
            $onEvent = ($property['on_event'] === '1');
            $eventName = trim($property['event_name']);
            $subProperties = null;

            if ((int) $property['child_count'] > 0) {
                $subProperties = $this->getChildrenList($property['id'], $module);
            }

            $value = $property['value'];
            $name = $property['name'];
            unset(
                $property['name'],
                $property['value'],
                $property['id'],
                $property['child_count'],
                $property['on_event'],
                $property['event_name'],
                $property['parent_id']
            );

            if (!empty($subProperties)) {
                if (empty($value)) {
                    $property = $subProperties;
                } else {
                    $property = [
                        ['startArrayOf' => $value],
                        $subProperties,
                        ['endArrayOf' => true],
                    ];
                }
            } else {
                $property = '{% endverbatim %}' . $value . '{% verbatim %}';
            }

            if ($root) {
                $key = ($onEvent ? 'onEvent' : 'default');
                if ($key === 'onEvent' && !empty($eventName)) {
                    $namedProperties[$key]['event'] = $eventName;
                }
                $namedProperties[$key][$name] = $property;
            } else {
                $namedProperties[$name] = $property;
            }
        }

        return $namedProperties;
    }


    private function castArrayValues(&$value, $key): void
    {
        if (in_array($key, self::STRING_VALUES, true)) {
            return;
        }

        if (preg_match('/^\"(.*)\"$/', $value)) {
            $value = json_decode($value);

            return;
        }

        switch (true) {
            case is_array(json_decode($value)):
            case is_int(json_decode($value)):
            case is_float(json_decode($value)):
            case is_bool(json_decode($value)):
                $value = json_decode($value);
        }
    }
}
