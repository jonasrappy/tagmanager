<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Api;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImportExportController extends AbstractController
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    #[Route(path: '/api/_action/wbm-tagmanager/export', name: 'api.action.core.wbm-tagmanager.export', defaults: ['_routeScope' =>  ['api']], methods: ['GET'])]
    public function export(): JsonResponse
    {
        $data = [];
        $models = ['wbm_data_layer_modules', 'wbm_data_layer_properties'];

        foreach ($models as $model) {
            $data[$model] = $this->getQueryBuilder($model)->executeQuery()->fetchAllAssociative();

            if ($model === 'wbm_data_layer_properties') {
                $data[$model] = $this->getChildrenRecursive($data[$model], $data[$model]);
            }
        }

        $response = new JsonResponse(json_encode($data, JSON_PRETTY_PRINT));
        $response->headers->set('Content-Disposition', 'attachment; filename="dataLayer.json"');

        return $response;
    }

    #[Route(path: '/api/_action/wbm-tagmanager/import', name: 'api.action.core.wbm-tagmanager.import', defaults: ['_routeScope' => ['api']], methods: ['POST'])]
    public function import(Request $request): JsonResponse
    {
        $file = $request->files->get('file');

        $truncateTables = $request->get('truncate') === 'true';

        $data = file_get_contents($file->getPathname());
        $data = json_decode($data, true);

        if (!empty($data) && $truncateTables) {
            $this->connection->query('DELETE FROM wbm_data_layer_properties');
            $this->connection->query('DELETE FROM wbm_data_layer_modules');
        }

        if (!empty($data)) {
            foreach ($data as $table => $items) {
                if (!in_array($table, ['wbm_data_layer_modules', 'wbm_data_layer_properties'], true)) {
                    return new JsonResponse(['success' => false]);
                }

                foreach ($items as $item) {
                    foreach (['id', 'parent_id', 'after_id'] as $key) {
                        if (!empty($item[$key])) {
                            $item[$key] = Uuid::fromHexToBytes($item[$key]);
                        }
                    }

                    try {
                        $this->connection->insert(
                            $table,
                            $item
                        );
                    } catch (\Exception $exception) {
                    }
                }
            }
        }

        return new JsonResponse(['success' => true]);
    }

    private function getChildrenRecursive(array $data, array $parents): array
    {
        foreach ($parents as $row) {
            $children = $this->getQueryBuilder('wbm_data_layer_properties', $row['id'])->execute()
                ->fetchAll(\PDO::FETCH_ASSOC);

            if (!empty($children)) {
                $data = array_merge($data, $children);
                $data = $this->getChildrenRecursive($data, $children);
            }
        }

        return $data;
    }

    private function getQueryBuilder(string $model, ?string $parentId = null): QueryBuilder
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select([
            '*',
            'LOWER(HEX(id)) as id',
        ])
            ->from($model);

        if ($model === 'wbm_data_layer_properties') {
            $qb->addSelect('LOWER(HEX(parent_id)) as parent_id');
            $qb->addSelect('LOWER(HEX(after_id)) as after_id');
            if ($parentId === null) {
                $qb->where('parent_id IS NULL');
            } else {
                $qb->where('parent_id = :parentId');
                $qb->setParameter('parentId', Uuid::fromHexToBytes($parentId));
            }
        }

        return $qb;
    }
}
