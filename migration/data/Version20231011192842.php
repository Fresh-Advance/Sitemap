<?php

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231011192842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create sitemap urls table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "CREATE TABLE fa_sitemap (
                id INT AUTO_INCREMENT,
                object_id VARCHAR(32),
                object_type VARCHAR(32),
                location VARCHAR(255),
                modified TIMESTAMP,
                added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY unique_object (object_id, object_type),
                INDEX idx_object_id (object_id)
            );"
        );
    }

    public function down(Schema $schema): void
    {
    }
}
