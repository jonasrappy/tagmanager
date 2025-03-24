<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1677050041CompatibilityGA4 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1677050041;
    }

    public function update(Connection $connection): void
    {
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.home.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.category.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.search.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.listing.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.product-detail.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.add-to-cart.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.remove-from-cart.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.cart-page.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.cart-offcanvas.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.checkout-register.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.checkout-confirm.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/properties.1677050041.checkout-finish.sql'));
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
