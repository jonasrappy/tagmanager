<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class WbmTagManagerAnalytics extends Plugin
{
    public function uninstall(UninstallContext $uninstallContext): void
    {
        if (!$uninstallContext->keepUserData()) {
            $this->container->get('Doctrine\DBAL\Connection')->executeStatement(
                'DROP TABLE `wbm_data_layer_properties`;'
            );

            $this->container->get('Doctrine\DBAL\Connection')->executeStatement(
                'DROP TABLE `wbm_data_layer_modules`;'
            );
        }
    }
}
