<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012204720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE exchange (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE stock_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER NOT NULL, exchange_id INTEGER NOT NULL, stock_type_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , price INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_56D83E28979B1AD6 ON stock_price (company_id)');
        $this->addSql('CREATE INDEX IDX_56D83E2868AFD1A0 ON stock_price (exchange_id)');
        $this->addSql('CREATE INDEX IDX_56D83E28DCEA9C30 ON stock_price (stock_type_id)');
        $this->addSql('CREATE TABLE stock_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('DROP TABLE stock_price');
        $this->addSql('DROP TABLE stock_type');
    }
}
