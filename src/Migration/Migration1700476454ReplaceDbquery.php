<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1700476454ReplaceDbquery extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1700476454;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(file_get_contents(__DIR__ . '/properties.1700476454.replaceDbquery.sql'));
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
