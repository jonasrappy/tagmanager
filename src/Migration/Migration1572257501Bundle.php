<?php declare(strict_types=1);

namespace Wbm\TagManagerAnalytics\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\DriverException;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1572257501Bundle extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1572257501;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery(
            '
            CREATE TABLE IF NOT EXISTS `wbm_data_layer_modules` (
              `id` BINARY(16) NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `module` VARCHAR(255) NOT NULL,
              `response` VARCHAR(255) NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `module` (`module`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        '
        );

        $connection->executeQuery(
            '
            CREATE TABLE IF NOT EXISTS `wbm_data_layer_properties` (
              `id` BINARY(16) NOT NULL,
              `module` VARCHAR(255) NOT NULL,
              `parent_id` BINARY(16) NULL,
              `after_id` BINARY(16) NULL,
              `child_count` INT(11) DEFAULT 0,
              `name` VARCHAR(255) NOT NULL,
              `value` TEXT,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`),
              KEY `parent_id` (`parent_id`),
              CONSTRAINT `fk.wbm_data_layer_properties.module` FOREIGN KEY (`module`)
                REFERENCES `wbm_data_layer_modules` (`module`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        '
        );

        $connection->executeQuery(file_get_contents(__DIR__ . '/layers.default.sql'));
        $connection->executeQuery(file_get_contents(__DIR__ . '/properties.default.sql'));

        try {
            $connection->executeQuery(
                'ALTER TABLE `wbm_data_layer_properties`
                  ADD CONSTRAINT `fk.wbm_data_layer_properties.parent_id` FOREIGN KEY (`parent_id`)
                  REFERENCES `wbm_data_layer_properties` (`id`) ON DELETE CASCADE;'
            );
        } catch (DriverException $e) {
            // getErrorCode was removed in v3
            $code = method_exists($e, 'getErrorCode') ? $e->getErrorCode : $e->getCode();
            if ($code === 1826) {
                // key may exist when updating from old plugin
            }
        }
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
