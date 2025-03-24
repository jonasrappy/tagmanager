<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Twig;

use Doctrine\DBAL\Connection;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Content\Product\Aggregate\ProductManufacturer\ProductManufacturerEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Content\Property\Aggregate\PropertyGroupOption\PropertyGroupOptionEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\Context\SalesChannelContextServiceInterface;
use Shopware\Core\System\SalesChannel\Context\SalesChannelContextServiceParameters;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Wbm\TagManagerAnalytics\Utility\SessionUtility;

class TagManagerExtension extends AbstractExtension
{
    private array $_cache = [];

    public function __construct(
        private readonly Connection $connection,
        private readonly CartService $cartService,
        private readonly EntityRepository $productRepository,
        private readonly EntityRepository $categoryRepository,
        private readonly SalesChannelContextServiceInterface $salesChannelContextService,
        private readonly RequestStack $requestStack
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('itembrand', [$this, 'getItemBrand'], ['needs_context' => true]),
            new TwigFunction('itemname', [$this, 'getItemName'], ['needs_context' => true]),
            new TwigFunction('itemnumber', [$this, 'getItemNumber'], ['needs_context' => true]),
            new TwigFunction('itemcategory', [$this, 'getItemCategory'], ['needs_context' => true]),
            new TwigFunction('pagecategory', [$this, 'getPageCategory'], ['needs_context' => true]),
            new TwigFunction('cartaddprice', [$this, 'cartaddprice'], ['needs_context' => true]),
            new TwigFunction('cartremoveprice', [$this, 'cartremoveprice'], ['needs_context' => true]),
            new TwigFunction('languageid', [$this, 'languageid'], ['needs_context' => true]),
            new TwigFunction('currencyiso', [$this, 'currencyiso'], ['needs_context' => true]),
            new TwigFunction('getvariantdescription', [$this, 'getvariantdescription'], ['needs_context' => true]),
            new TwigFunction('getparam', [$this, 'getparam']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('uuid2bytes', [$this, 'uuid2bytes']),
        ];
    }

    private function getItem($twigContext, $id)
    {
        $context = $this->getSalesChannelContext($twigContext)->getContext();

        $criteria = new Criteria();
        $criteria->addAssociation('manufacturer');
        $criteria->addFilter(new EqualsFilter('id', $id));

        return $this->productRepository->search($criteria, $context)->first();
    }

    public function getItemName($twigContext, $id)
    {
        $product = $this->getItem($twigContext, $id);

        if (!$product instanceof ProductEntity) {
            return sprintf('product with id %s not found', $id);
        }

        return $product->getTranslated()['name'] ?? $product->getName();
    }

    public function getItemNumber($twigContext, $id)
    {
        $product = $this->getItem($twigContext, $id);

        if (!$product instanceof ProductEntity) {
            return sprintf('product with id %s not found', $id);
        }

        return $product->getProductNumber();
    }

    public function getItemBrand($twigContext, string $id): string
    {
        $product = $this->getItem($twigContext, $id);

        if (!$product instanceof ProductEntity) {
            return sprintf('product with id %s not found', $id);
        }

        if (!$product->getManufacturer() instanceof ProductManufacturerEntity) {
            return '';
        }

        return $product->getManufacturer()->getTranslated()['name'] ?? $product->getManufacturer()->getName();
    }

    public function getItemCategory($twigContext, $id)
    {
        $product = $this->getItem($twigContext, $id);

        if (!$product instanceof ProductEntity) {
            return sprintf('product with id %s not found', $id);
        }

        $categoryTree = $product->getCategoryTree();
        if ($categoryTree === null) {
            return '';
        }

        $categoryId = end($categoryTree);
        $category = $this->categoryRepository->search(
            new Criteria([$categoryId]),
            $this->getSalesChannelContext($twigContext)->getContext()
        )->first();

        if (!$category instanceof CategoryEntity) {
            return '';
        }

        return $category->getTranslated()['name'] ?? $category->getName();
    }

    public function getPageCategory($twigContext)
    {
        $navigationId = $this->getparam('navigationId');
        $context = $this->getSalesChannelContext($twigContext)->getContext();

        $category = $this->categoryRepository->search(new Criteria([$navigationId]), $context)->first();

        if (!$category instanceof CategoryEntity) {
            return sprintf('category with id %s not found', $navigationId);
        }

        return $category->getTranslated()['name'] ?? $category->getName();
    }

    public function uuid2bytes(?string $uuid = ''): string
    {
        if ($uuid) {
            return Uuid::fromHexToBytes($uuid);
        }

        return '';
    }

    public function languageid($twigContext): string
    {
        $context = $this->getSalesChannelContext($twigContext)->getContext();

        return $this->uuid2bytes($context->getLanguageId());
    }

    public function currencyiso($twigContext)
    {
        $salesChannelContext = $this->getSalesChannelContext($twigContext);

        return $salesChannelContext->getCurrency()->getIsoCode();
    }

    public function cartaddprice(): int
    {
        $session = $this->requestStack->getMainRequest()->getSession();
        $session->set(SessionUtility::UPDATE_FLAG, SessionUtility::ADDCART_UPDATEFLAG_VALUE);
        // price will be saved to session in "Subscriber/AddToCart/AfterLineItemAddedSubscriber"
        // and before passing it to FE the correct price will be injected into datalayer

        return 0;
    }

    public function cartremoveprice(
        $twigContext,
        string $uuid = '',
        $returnQuantity = false
    ): float {
        $salesChannelContext = $this->getSalesChannelContext($twigContext);

        $cart = $this->cartService->getCart($salesChannelContext->getToken(), $salesChannelContext);

        $lineItem = $cart->getLineItems()->get($uuid);

        if ($lineItem && $lineItem->getId() === $uuid) {
            if ($returnQuantity) {
                return (float) $lineItem->getQuantity();
            }

            return ($lineItem->getPrice() !== null) ? $lineItem->getPrice()->getUnitPrice() : 0;
        }

        return 0;
    }

    public function getvariantdescription(
        $twigContext,
        $param
    ): string {
        if (is_array($param)) {
            $optionNames = '';

            foreach ($param as $option) {
                if ($option instanceof PropertyGroupOptionEntity) {
                    $optionNames .= ';' . $option->getName();

                    continue;
                }

                $optionNames .= ';' . @$option['option'];
            }

            return ltrim($optionNames, ';');
        }

        $productId = $param;

        $query = $this->connection->createQueryBuilder();
        $query->select('option_translation.name')
            ->from('product', 'product')
            ->innerJoin(
                'product',
                'product_option',
                'product_group',
                'product_group.product_id = product.id'
            )
            ->innerJoin(
                'product_group',
                'property_group_option',
                'product_option',
                'product_group.property_group_option_id = product_option.id'
            )
            ->innerJoin(
                'product_option',
                'property_group_option_translation',
                'option_translation',
                'option_translation.property_group_option_id = product_option.id'
            )
            ->where('product.id = :id')
            ->setParameter('id', $this->uuid2bytes($productId))
            ->andWhere('product.parent_id IS NOT NULL')
            ->andWhere('product.option_ids IS NOT NULL')
            ->andWhere('option_translation.language_id = :languageId')
            ->setParameter('languageId', $this->languageid($twigContext));

        $optionNames = $query->execute()->fetchAll(\PDO::FETCH_COLUMN);

        if (is_array($optionNames)) {
            return implode(';', $optionNames);
        }

        if (!empty($optionNames)) {
            return (string) $optionNames;
        }

        return '';
    }

    public function getparam(string $param)
    {
        $parameters = array_merge(
            $this->requestStack->getCurrentRequest()->request->all(),
            $this->requestStack->getCurrentRequest()->get('_route_params')
        );

        return @$parameters[$param];
    }

    private function getSalesChannelContext($twigContext): SalesChannelContext
    {
        if (
            !array_key_exists('context', $twigContext)
            || !$twigContext['context'] instanceof SalesChannelContext
        ) {
            /** @var Request $mainRequest */
            $mainRequest = $this->requestStack->getMainRequest();
            $salesChannelContext = $mainRequest->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_CONTEXT_OBJECT);

            if ($salesChannelContext instanceof SalesChannelContext) {
                $twigContext['context'] = $salesChannelContext;
            } else {
                $twigContext['context'] = $this->manuallyCreateSalesChannelContext($mainRequest);
            }
        }

        return $twigContext['context'];
    }

    /**
     * Fallback if something went wrong with the sales channel context
     */
    private function manuallyCreateSalesChannelContext(Request $mainRequest): SalesChannelContext
    {
        $salesChannelId = $mainRequest->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_ID);
        $contextToken = $mainRequest->headers->get(PlatformRequest::HEADER_CONTEXT_TOKEN);
        $languageId = $mainRequest->headers->get(PlatformRequest::HEADER_LANGUAGE_ID);

        $parameters = new SalesChannelContextServiceParameters(
            $salesChannelId,
            $contextToken,
            $languageId
        );
        return $this->salesChannelContextService->get($parameters);
    }
}
