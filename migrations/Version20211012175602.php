<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012175602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_56D83E28DCEA9C30');
        $this->addSql('DROP INDEX IDX_56D83E2868AFD1A0');
        $this->addSql('DROP INDEX IDX_56D83E28979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stock_price AS SELECT id, company_id, exchange_id, stock_type_id, created_at, updated_at, price FROM stock_price');
        $this->addSql('DROP TABLE stock_price');
        $this->addSql('CREATE TABLE stock_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER NOT NULL, exchange_id INTEGER NOT NULL, stock_type_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , price INTEGER NOT NULL, CONSTRAINT FK_56D83E28979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_56D83E2868AFD1A0 FOREIGN KEY (exchange_id) REFERENCES exchange (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_56D83E28DCEA9C30 FOREIGN KEY (stock_type_id) REFERENCES stock_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO stock_price (id, company_id, exchange_id, stock_type_id, created_at, updated_at, price) SELECT id, company_id, exchange_id, stock_type_id, created_at, updated_at, price FROM __temp__stock_price');
        $this->addSql('DROP TABLE __temp__stock_price');
        $this->addSql('CREATE INDEX IDX_56D83E28DCEA9C30 ON stock_price (stock_type_id)');
        $this->addSql('CREATE INDEX IDX_56D83E2868AFD1A0 ON stock_price (exchange_id)');
        $this->addSql('CREATE INDEX IDX_56D83E28979B1AD6 ON stock_price (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_56D83E28979B1AD6');
        $this->addSql('DROP INDEX IDX_56D83E2868AFD1A0');
        $this->addSql('DROP INDEX IDX_56D83E28DCEA9C30');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stock_price AS SELECT id, company_id, exchange_id, stock_type_id, created_at, updated_at, price FROM stock_price');
        $this->addSql('DROP TABLE stock_price');
        $this->addSql('CREATE TABLE stock_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER NOT NULL, exchange_id INTEGER NOT NULL, stock_type_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO stock_price (id, company_id, exchange_id, stock_type_id, created_at, updated_at, price) SELECT id, company_id, exchange_id, stock_type_id, created_at, updated_at, price FROM __temp__stock_price');
        $this->addSql('DROP TABLE __temp__stock_price');
        $this->addSql('CREATE INDEX IDX_56D83E28979B1AD6 ON stock_price (company_id)');
        $this->addSql('CREATE INDEX IDX_56D83E2868AFD1A0 ON stock_price (exchange_id)');
        $this->addSql('CREATE INDEX IDX_56D83E28DCEA9C30 ON stock_price (stock_type_id)');
    }
}
