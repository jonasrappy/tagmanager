<?php

namespace Wbm\TagManagerAnalytics\Utility;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionUtility
{
    public const ATTRIBUTE_NAME = 'wbm-stored-datalayer';

    public const UPDATE_FLAG = 'wbm-stored-shouldUpdate';

    public const ADDCART_UPDATEFLAG_VALUE = 'cartaddprice';
    public const ADDCART_CART_ITEMS = 'wbm-stored-addCart-addedCartItems';

    public static function injectSessionVars(array $dataLayers, SessionInterface $session): array
    {
        if (!$session->has(self::UPDATE_FLAG)) {
            return $dataLayers;
        }

        if ($session->get(self::UPDATE_FLAG) === self::ADDCART_UPDATEFLAG_VALUE) {
            try {
                $lineItems = $session->get(self::ADDCART_CART_ITEMS);
                foreach ($dataLayers as $key => $dataLayer) {
                    $dataLayer = json_decode($dataLayer, true, 512, JSON_THROW_ON_ERROR);
                    if (empty($dataLayer)) {
                        continue;
                    }

                    $conversion = 0;
                    foreach ($dataLayer['ecommerce']['items'] as $itemKey => $product) {
                        if (isset($lineItems[$product['item_id']])) {
                            $lineItemValue = $lineItems[$product['item_id']];
                            $product['price'] = $lineItemValue;
                            $conversion += $lineItemValue * $product['quantity'];
                            $dataLayer['ecommerce']['items'][$itemKey] = $product;
                        }
                    }

                    $dataLayer['ecommerce']['value'] = $conversion;
                    $dataLayer = json_encode($dataLayer, JSON_THROW_ON_ERROR);

                    $dataLayers[$key] = $dataLayer;
                }
            } catch (\Throwable $t) {
                // Ensure session vars are removed on error
            }

            $session->remove(self::UPDATE_FLAG);
            $session->remove(self::ADDCART_CART_ITEMS);
        }

        return $dataLayers;
    }
}
