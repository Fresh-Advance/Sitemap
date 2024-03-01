<?php

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240229211655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update object id field type to fit other shop tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "ALTER TABLE fa_sitemap
                MODIFY COLUMN object_id VARCHAR(32) CHARACTER SET latin1 collate latin1_general_ci NOT NULL"
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
