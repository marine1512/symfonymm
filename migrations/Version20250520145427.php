<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520145427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE sweatshirt ADD roles JSON NOT NULL, CHANGE stock_by_size stock_by_size JSON NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE roles roles JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT 'NULL' COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sweatshirt DROP roles, CHANGE stock_by_size stock_by_size LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE image image VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`
        SQL);
    }
}
