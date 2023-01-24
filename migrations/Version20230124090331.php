<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124090331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, rating DOUBLE PRECISION NOT NULL, price INTEGER NOT NULL, inet_price INTEGER DEFAULT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO product (id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at) SELECT id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD4584665A ON product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, rating DOUBLE PRECISION NOT NULL, price INTEGER NOT NULL, inet_price INTEGER DEFAULT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO product (id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at) SELECT id, product_id, title, description, rating, price, inet_price, image, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }
}
