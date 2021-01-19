<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119080233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city VARCHAR(120) DEFAULT NULL, country VARCHAR(120) DEFAULT NULL, phone VARCHAR(60) DEFAULT NULL, mobile VARCHAR(60) DEFAULT NULL, email VARCHAR(120) DEFAULT NULL, whatsapp VARCHAR(120) DEFAULT NULL, wechat VARCHAR(120) DEFAULT NULL, skype VARCHAR(120) DEFAULT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('CREATE TABLE customer_broker (customer_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(customer_id, broker_id))');
        $this->addSql('CREATE INDEX IDX_476F2C6A9395C3F3 ON customer_broker (customer_id)');
        $this->addSql('CREATE INDEX IDX_476F2C6A6CC064FC ON customer_broker (broker_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL, date_sent DATE DEFAULT NULL)');
        $this->addSql('CREATE TABLE message_broker (message_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(message_id, broker_id))');
        $this->addSql('CREATE INDEX IDX_C18D6D34537A1329 ON message_broker (message_id)');
        $this->addSql('CREATE INDEX IDX_C18D6D346CC064FC ON message_broker (broker_id)');
        $this->addSql('CREATE TABLE message_supplier (message_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(message_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_920CA86F537A1329 ON message_supplier (message_id)');
        $this->addSql('CREATE INDEX IDX_920CA86F2ADD6D8C ON message_supplier (supplier_id)');
        $this->addSql('CREATE TABLE message_customer (message_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(message_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_881F4A18537A1329 ON message_customer (message_id)');
        $this->addSql('CREATE INDEX IDX_881F4A189395C3F3 ON message_customer (customer_id)');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, details CLOB DEFAULT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE note_customer (note_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(note_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_9162529726ED0855 ON note_customer (note_id)');
        $this->addSql('CREATE INDEX IDX_916252979395C3F3 ON note_customer (customer_id)');
        $this->addSql('CREATE TABLE note_broker (note_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(note_id, broker_id))');
        $this->addSql('CREATE INDEX IDX_EE78A7EF26ED0855 ON note_broker (note_id)');
        $this->addSql('CREATE INDEX IDX_EE78A7EF6CC064FC ON note_broker (broker_id)');
        $this->addSql('CREATE TABLE note_supplier (note_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(note_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_8B71B0E026ED0855 ON note_supplier (note_id)');
        $this->addSql('CREATE INDEX IDX_8B71B0E02ADD6D8C ON note_supplier (supplier_id)');
        $this->addSql('CREATE TABLE note_product (note_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(note_id, product_id))');
        $this->addSql('CREATE INDEX IDX_52ECC03726ED0855 ON note_product (note_id)');
        $this->addSql('CREATE INDEX IDX_52ECC0374584665A ON note_product (product_id)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specifications_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('CREATE TABLE product_customer (product_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(product_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_4A89E49E4584665A ON product_customer (product_id)');
        $this->addSql('CREATE INDEX IDX_4A89E49E9395C3F3 ON product_customer (customer_id)');
        $this->addSql('CREATE TABLE product_supplier (product_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(product_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_509A06E94584665A ON product_supplier (product_id)');
        $this->addSql('CREATE INDEX IDX_509A06E92ADD6D8C ON product_supplier (supplier_id)');
        $this->addSql('CREATE TABLE specification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, details CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('CREATE TABLE supplier_broker (supplier_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, broker_id))');
        $this->addSql('CREATE INDEX IDX_2DC822EF2ADD6D8C ON supplier_broker (supplier_id)');
        $this->addSql('CREATE INDEX IDX_2DC822EF6CC064FC ON supplier_broker (broker_id)');
        $this->addSql('CREATE TABLE supplier_customer (supplier_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_CB0E6882ADD6D8C ON supplier_customer (supplier_id)');
        $this->addSql('CREATE INDEX IDX_CB0E6889395C3F3 ON supplier_customer (customer_id)');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
        $this->addSql('CREATE TABLE symfony_demo_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D5855405E237E06 ON symfony_demo_tag (name)');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE broker');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_broker');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_broker');
        $this->addSql('DROP TABLE message_supplier');
        $this->addSql('DROP TABLE message_customer');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE note_customer');
        $this->addSql('DROP TABLE note_broker');
        $this->addSql('DROP TABLE note_supplier');
        $this->addSql('DROP TABLE note_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_customer');
        $this->addSql('DROP TABLE product_supplier');
        $this->addSql('DROP TABLE specification');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE supplier_broker');
        $this->addSql('DROP TABLE supplier_customer');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_tag');
        $this->addSql('DROP TABLE symfony_demo_user');
    }
}
