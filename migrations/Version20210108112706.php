<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108112706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE customer_contact');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_F6AAF03BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('DROP INDEX IDX_81398E096CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, broker_id, contact_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_81398E096CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_81398E09E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer (id, broker_id, contact_id, name, date_added, date_edited) SELECT id, broker_id, contact_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('CREATE INDEX IDX_81398E096CC064FC ON customer (broker_id)');
        $this->addSql('DROP INDEX IDX_AA6094C19395C3F3');
        $this->addSql('DROP INDEX IDX_AA6094C1537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_message AS SELECT customer_id, message_id FROM customer_message');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('CREATE TABLE customer_message (customer_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(customer_id, message_id), CONSTRAINT FK_AA6094C19395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA6094C1537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer_message (customer_id, message_id) SELECT customer_id, message_id FROM __temp__customer_message');
        $this->addSql('DROP TABLE __temp__customer_message');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('DROP INDEX IDX_B6BD307F9395C3F3');
        $this->addSql('DROP INDEX IDX_B6BD307F6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, customer_id, broker_id, text, date_added, date_edited, sent_by FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER DEFAULT NULL, broker_id INTEGER NOT NULL, text CLOB NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_B6BD307F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F6CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, customer_id, broker_id, text, date_added, date_edited, sent_by) SELECT id, customer_id, broker_id, text, date_added, date_edited, sent_by FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F9395C3F3 ON message (customer_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F6CC064FC ON message (broker_id)');
        $this->addSql('DROP INDEX IDX_CFBDFA146CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, broker_id FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, CONSTRAINT FK_CFBDFA146CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CFBDFA149395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO note (id, broker_id) SELECT id, broker_id FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA146CC064FC ON note (broker_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149395C3F3 ON note (customer_id)');
        $this->addSql('DROP INDEX IDX_9B2A6C7E537A1329');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('DROP INDEX IDX_9B2A6C7E6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, message_id, contact_id, broker_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message_id INTEGER DEFAULT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_9B2A6C7E537A1329 FOREIGN KEY (message_id) REFERENCES message (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B2A6C7EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B2A6C7E6CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier (id, message_id, contact_id, broker_id, name, date_added, date_edited) SELECT id, message_id, contact_id, broker_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE INDEX IDX_9B2A6C7E537A1329 ON supplier (message_id)');
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
        $this->addSql('CREATE TABLE customer_contact (customer_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, PRIMARY KEY(customer_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_50BF42869395C3F3 ON customer_contact (customer_id)');
        $this->addSql('CREATE INDEX IDX_50BF4286E7A1254A ON customer_contact (contact_id)');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX IDX_81398E096CC064FC');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, broker_id, contact_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO customer (id, broker_id, contact_id, name, date_added, date_edited) SELECT id, broker_id, contact_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE INDEX IDX_81398E096CC064FC ON customer (broker_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('DROP INDEX IDX_AA6094C19395C3F3');
        $this->addSql('DROP INDEX IDX_AA6094C1537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_message AS SELECT customer_id, message_id FROM customer_message');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('CREATE TABLE customer_message (customer_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(customer_id, message_id))');
        $this->addSql('INSERT INTO customer_message (customer_id, message_id) SELECT customer_id, message_id FROM __temp__customer_message');
        $this->addSql('DROP TABLE __temp__customer_message');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('DROP INDEX IDX_B6BD307F9395C3F3');
        $this->addSql('DROP INDEX IDX_B6BD307F6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, customer_id, broker_id, text, date_added, date_edited, sent_by FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER DEFAULT NULL, broker_id INTEGER NOT NULL, text CLOB NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL)');
        $this->addSql('INSERT INTO message (id, customer_id, broker_id, text, date_added, date_edited, sent_by) SELECT id, customer_id, broker_id, text, date_added, date_edited, sent_by FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F9395C3F3 ON message (customer_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F6CC064FC ON message (broker_id)');
        $this->addSql('DROP INDEX IDX_CFBDFA146CC064FC');
        $this->addSql('DROP INDEX IDX_CFBDFA149395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, broker_id FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, broker_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO note (id, broker_id) SELECT id, broker_id FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA146CC064FC ON note (broker_id)');
        $this->addSql('DROP INDEX IDX_9B2A6C7E537A1329');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('DROP INDEX IDX_9B2A6C7E6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, message_id, contact_id, broker_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message_id INTEGER DEFAULT NULL, contact_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO supplier (id, message_id, contact_id, broker_id, name, date_added, date_edited) SELECT id, message_id, contact_id, broker_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE INDEX IDX_9B2A6C7E537A1329 ON supplier (message_id)');
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
