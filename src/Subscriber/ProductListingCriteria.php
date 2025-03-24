<?php

namespace Wbm\TagManagerAnalytics\Subscriber;

use Shopware\Core\Content\Product\Events\ProductListingCriteriaEvent;
use Shopware\Core\Content\Product\ProductEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductListingCriteria implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_LISTING_CRITERIA => 'addProductListingCriteria',
        ];
    }

    public function addProductListingCriteria(ProductListingCriteriaEvent $event): void
    {
        $criteria = $event->getCriteria();
        $criteria->addAssociations(['categories']);
    }
}
