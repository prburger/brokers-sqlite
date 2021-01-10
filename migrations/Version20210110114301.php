<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110114301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_F6AAF03BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX IDX_81398E096CC064FC');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, contact_id, broker_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_81398E09E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_81398E096CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer (id, contact_id, broker_id, name, date_added, date_edited) SELECT id, contact_id, broker_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE INDEX IDX_81398E096CC064FC ON customer (broker_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('DROP INDEX IDX_B6BD307F9395C3F3');
        $this->addSql('DROP INDEX IDX_B6BD307F5316C376');
        $this->addSql('DROP INDEX IDX_B6BD307FC3568B40');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, brokers_id, text, date_added, date_edited, sent_by FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brokers_id INTEGER NOT NULL, text CLOB NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_B6BD307F5316C376 FOREIGN KEY (brokers_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, brokers_id, text, date_added, date_edited, sent_by) SELECT id, brokers_id, text, date_added, date_edited, sent_by FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F5316C376 ON message (brokers_id)');
        $this->addSql('DROP INDEX IDX_CFBDFA146CC064FC');
        $this->addSql('DROP INDEX IDX_CFBDFA149395C3F3');
        $this->addSql('DROP INDEX IDX_CFBDFA142ADD6D8C');
        $this->addSql('DROP INDEX IDX_CFBDFA144584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, broker_id, customer_id, supplier_id, product_id FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_CFBDFA146CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CFBDFA149395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CFBDFA142ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CFBDFA144584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO note (id, broker_id, customer_id, supplier_id, product_id) SELECT id, broker_id, customer_id, supplier_id, product_id FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA146CC064FC ON note (broker_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149395C3F3 ON note (customer_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA142ADD6D8C ON note (supplier_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA144584665A ON note (product_id)');
        $this->addSql('DROP INDEX IDX_D34A04AD2ADD6D8C');
        $this->addSql('DROP INDEX UNIQ_D34A04ADBDE4EC11');
        $this->addSql('DROP INDEX IDX_D34A04AD9395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, specifications_id, customer_id, supplier_id, name, date_added, date_edited FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specifications_id INTEGER NOT NULL, customer_id VARCHAR(120) DEFAULT NULL COLLATE BINARY, supplier_id VARCHAR(120) DEFAULT NULL COLLATE BINARY, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_D34A04ADBDE4EC11 FOREIGN KEY (specifications_id) REFERENCES specification (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04AD9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, specifications_id, customer_id, supplier_id, name, date_added, date_edited) SELECT id, specifications_id, customer_id, supplier_id, name, date_added, date_edited FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD2ADD6D8C ON product (supplier_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9395C3F3 ON product (customer_id)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('DROP INDEX IDX_9B2A6C7E6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, contact_id, broker_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_9B2A6C7EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B2A6C7E6CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier (id, contact_id, broker_id, name, date_added, date_edited) SELECT id, contact_id, broker_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('CREATE INDEX IDX_9B2A6C7E6CC064FC ON supplier (broker_id)');
        $this->addSql('DROP INDEX IDX_53AD8F83F675F31B');
        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_comment AS SELECT id, post_id, author_id, content, published_at FROM symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_comment (id, post_id, author_id, content, published_at) SELECT id, post_id, author_id, content, published_at FROM __temp__symfony_demo_comment');
        $this->addSql('DROP TABLE __temp__symfony_demo_comment');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('DROP INDEX IDX_58A92E65F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, author_id, title, slug, summary, content, published_at FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, summary VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post (id, author_id, title, slug, summary, content, published_at) SELECT id, author_id, title, slug, summary, content, published_at FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('DROP INDEX IDX_6ABC1CC4BAD26311');
        $this->addSql('DROP INDEX IDX_6ABC1CC44B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post_tag AS SELECT post_id, tag_id FROM symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id), CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post_tag (post_id, tag_id) SELECT post_id, tag_id FROM __temp__symfony_demo_post_tag');
        $this->addSql('DROP TABLE __temp__symfony_demo_post_tag');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('DROP INDEX IDX_81398E096CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, contact_id, broker_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO customer (id, contact_id, broker_id, name, date_added, date_edited) SELECT id, contact_id, broker_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('CREATE INDEX IDX_81398E096CC064FC ON customer (broker_id)');
        $this->addSql('DROP INDEX IDX_B6BD307F5316C376');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, brokers_id, text, date_added, date_edited, sent_by FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brokers_id INTEGER NOT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL, customers_id INTEGER NOT NULL, customer_id VARCHAR(120) DEFAULT NULL COLLATE BINARY, broker_id VARCHAR(120) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO message (id, brokers_id, text, date_added, date_edited, sent_by) SELECT id, brokers_id, text, date_added, date_edited, sent_by FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F5316C376 ON message (brokers_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9395C3F3 ON message (customer_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FC3568B40 ON message (customers_id)');
        $this->addSql('DROP INDEX IDX_CFBDFA146CC064FC');
        $this->addSql('DROP INDEX IDX_CFBDFA149395C3F3');
        $this->addSql('DROP INDEX IDX_CFBDFA142ADD6D8C');
        $this->addSql('DROP INDEX IDX_CFBDFA144584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, broker_id, customer_id, supplier_id, product_id FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, product_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO note (id, broker_id, customer_id, supplier_id, product_id) SELECT id, broker_id, customer_id, supplier_id, product_id FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA146CC064FC ON note (broker_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149395C3F3 ON note (customer_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA142ADD6D8C ON note (supplier_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA144584665A ON note (product_id)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADBDE4EC11');
        $this->addSql('DROP INDEX IDX_D34A04AD9395C3F3');
        $this->addSql('DROP INDEX IDX_D34A04AD2ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, customer_id, supplier_id, specifications_id, name, date_added, date_edited FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id VARCHAR(120) DEFAULT NULL, supplier_id VARCHAR(120) DEFAULT NULL, specifications_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO product (id, customer_id, supplier_id, specifications_id, name, date_added, date_edited) SELECT id, customer_id, supplier_id, specifications_id, name, date_added, date_edited FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9395C3F3 ON product (customer_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD2ADD6D8C ON product (supplier_id)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('DROP INDEX IDX_9B2A6C7E6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, contact_id, broker_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO supplier (id, contact_id, broker_id, name, date_added, date_edited) SELECT id, contact_id, broker_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('CREATE INDEX IDX_9B2A6C7E6CC064FC ON supplier (broker_id)');
        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('DROP INDEX IDX_53AD8F83F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_comment AS SELECT id, post_id, author_id, content, published_at FROM symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO symfony_demo_comment (id, post_id, author_id, content, published_at) SELECT id, post_id, author_id, content, published_at FROM __temp__symfony_demo_comment');
        $this->addSql('DROP TABLE __temp__symfony_demo_comment');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('DROP INDEX IDX_58A92E65F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, author_id, title, slug, summary, content, published_at FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO symfony_demo_post (id, author_id, title, slug, summary, content, published_at) SELECT id, author_id, title, slug, summary, content, published_at FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('DROP INDEX IDX_6ABC1CC44B89032C');
        $this->addSql('DROP INDEX IDX_6ABC1CC4BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post_tag AS SELECT post_id, tag_id FROM symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('INSERT INTO symfony_demo_post_tag (post_id, tag_id) SELECT post_id, tag_id FROM __temp__symfony_demo_post_tag');
        $this->addSql('DROP TABLE __temp__symfony_demo_post_tag');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
    }
}
