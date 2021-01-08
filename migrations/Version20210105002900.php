<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105002900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('CREATE TABLE message_broker (message_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(message_id, broker_id))');
        $this->addSql('CREATE INDEX IDX_C18D6D34537A1329 ON message_broker (message_id)');
        $this->addSql('CREATE INDEX IDX_C18D6D346CC064FC ON message_broker (broker_id)');
        $this->addSql('CREATE TABLE message_supplier (message_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(message_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_920CA86F537A1329 ON message_supplier (message_id)');
        $this->addSql('CREATE INDEX IDX_920CA86F2ADD6D8C ON message_supplier (supplier_id)');
        $this->addSql('CREATE TABLE message_customer (message_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(message_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_881F4A18537A1329 ON message_customer (message_id)');
        $this->addSql('CREATE INDEX IDX_881F4A189395C3F3 ON message_customer (customer_id)');
        $this->addSql('CREATE TABLE notes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, details CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, messages CLOB DEFAULT NULL --(DC2Type:array)
        , notes CLOB DEFAULT NULL --(DC2Type:array)
        , CONSTRAINT FK_F6AAF03BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('DROP INDEX IDX_53AD8F83F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_comment AS SELECT id, post_id, author_id, content, published_at FROM symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_comment (id, post_id, author_id, content, published_at) SELECT id, post_id, author_id, content, published_at FROM __temp__symfony_demo_comment');
        $this->addSql('DROP TABLE __temp__symfony_demo_comment');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('DROP INDEX IDX_58A92E65F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, author_id, title, slug, summary, content, published_at FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, summary VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post (id, author_id, title, slug, summary, content, published_at) SELECT id, author_id, title, slug, summary, content, published_at FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('DROP INDEX IDX_6ABC1CC44B89032C');
        $this->addSql('DROP INDEX IDX_6ABC1CC4BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post_tag AS SELECT post_id, tag_id FROM symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id), CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post_tag (post_id, tag_id) SELECT post_id, tag_id FROM __temp__symfony_demo_post_tag');
        $this->addSql('DROP TABLE __temp__symfony_demo_post_tag');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_broker');
        $this->addSql('DROP TABLE message_supplier');
        $this->addSql('DROP TABLE message_customer');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
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