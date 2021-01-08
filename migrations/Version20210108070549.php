<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108070549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('CREATE TABLE broker_message (broker_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(broker_id, message_id))');
        $this->addSql('CREATE INDEX IDX_1DF33856CC064FC ON broker_message (broker_id)');
        $this->addSql('CREATE INDEX IDX_1DF3385537A1329 ON broker_message (message_id)');
        $this->addSql('CREATE TABLE broker_note (broker_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(broker_id, note_id))');
        $this->addSql('CREATE INDEX IDX_54068BB26CC064FC ON broker_note (broker_id)');
        $this->addSql('CREATE INDEX IDX_54068BB226ED0855 ON broker_note (note_id)');
        $this->addSql('CREATE TABLE broker_customer (broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(broker_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_DCE6F7086CC064FC ON broker_customer (broker_id)');
        $this->addSql('CREATE INDEX IDX_DCE6F7089395C3F3 ON broker_customer (customer_id)');
        $this->addSql('CREATE TABLE broker_supplier (broker_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(broker_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_C6F5157F6CC064FC ON broker_supplier (broker_id)');
        $this->addSql('CREATE INDEX IDX_C6F5157F2ADD6D8C ON broker_supplier (supplier_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city VARCHAR(120) DEFAULT NULL, country VARCHAR(120) DEFAULT NULL, phone VARCHAR(60) DEFAULT NULL, mobile VARCHAR(60) DEFAULT NULL, email VARCHAR(120) DEFAULT NULL, whatsapp VARCHAR(120) DEFAULT NULL, wechat VARCHAR(120) DEFAULT NULL, skype VARCHAR(120) DEFAULT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE customer_contact (customer_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, PRIMARY KEY(customer_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_50BF42869395C3F3 ON customer_contact (customer_id)');
        $this->addSql('CREATE INDEX IDX_50BF4286E7A1254A ON customer_contact (contact_id)');
        $this->addSql('CREATE TABLE customer_note (customer_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(customer_id, note_id))');
        $this->addSql('CREATE INDEX IDX_9B2C5E639395C3F3 ON customer_note (customer_id)');
        $this->addSql('CREATE INDEX IDX_9B2C5E6326ED0855 ON customer_note (note_id)');
        $this->addSql('CREATE TABLE customer_product (customer_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(customer_id, product_id))');
        $this->addSql('CREATE INDEX IDX_CF97A0139395C3F3 ON customer_product (customer_id)');
        $this->addSql('CREATE INDEX IDX_CF97A0134584665A ON customer_product (product_id)');
        $this->addSql('CREATE TABLE customer_message (customer_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(customer_id, message_id))');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER DEFAULT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, date_sent DATE DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9395C3F3 ON message (customer_id)');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('CREATE TABLE supplier_message (supplier_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, message_id))');
        $this->addSql('CREATE INDEX IDX_37D844602ADD6D8C ON supplier_message (supplier_id)');
        $this->addSql('CREATE INDEX IDX_37D84460537A1329 ON supplier_message (message_id)');
        $this->addSql('CREATE TABLE supplier_note (supplier_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, note_id))');
        $this->addSql('CREATE INDEX IDX_2E50CFD2ADD6D8C ON supplier_note (supplier_id)');
        $this->addSql('CREATE INDEX IDX_2E50CFD26ED0855 ON supplier_note (note_id)');
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
        $this->addSql('DROP INDEX UNIQ_8FB094A1E7927C74');
        $this->addSql('DROP INDEX UNIQ_8FB094A1F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_user AS SELECT id, full_name, username, email, password, roles FROM symfony_demo_user');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL COLLATE BINARY, username VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO symfony_demo_user (id, full_name, username, email, password, roles) SELECT id, full_name, username, email, password, roles FROM __temp__symfony_demo_user');
        $this->addSql('DROP TABLE __temp__symfony_demo_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE broker');
        $this->addSql('DROP TABLE broker_message');
        $this->addSql('DROP TABLE broker_note');
        $this->addSql('DROP TABLE broker_customer');
        $this->addSql('DROP TABLE broker_supplier');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_contact');
        $this->addSql('DROP TABLE customer_note');
        $this->addSql('DROP TABLE customer_product');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE supplier_message');
        $this->addSql('DROP TABLE supplier_note');
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
        $this->addSql('DROP INDEX UNIQ_8FB094A1F85E0677');
        $this->addSql('DROP INDEX UNIQ_8FB094A1E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_user AS SELECT id, full_name, username, email, password, roles FROM symfony_demo_user');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO symfony_demo_user (id, full_name, username, email, password, roles) SELECT id, full_name, username, email, password, roles FROM __temp__symfony_demo_user');
        $this->addSql('DROP TABLE __temp__symfony_demo_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
    }
}
