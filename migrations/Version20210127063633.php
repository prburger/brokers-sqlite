<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127063633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE broker_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE note_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE specification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE supplier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE symfony_demo_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE symfony_demo_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE symfony_demo_tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE broker (id INT NOT NULL, contact_id INT NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('CREATE TABLE broker_message (broker_id INT NOT NULL, message_id INT NOT NULL, PRIMARY KEY(broker_id, message_id))');
        $this->addSql('CREATE INDEX IDX_1DF33856CC064FC ON broker_message (broker_id)');
        $this->addSql('CREATE INDEX IDX_1DF3385537A1329 ON broker_message (message_id)');
        $this->addSql('CREATE TABLE broker_customer (broker_id INT NOT NULL, customer_id INT NOT NULL, PRIMARY KEY(broker_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_DCE6F7086CC064FC ON broker_customer (broker_id)');
        $this->addSql('CREATE INDEX IDX_DCE6F7089395C3F3 ON broker_customer (customer_id)');
        $this->addSql('CREATE TABLE broker_note (broker_id INT NOT NULL, note_id INT NOT NULL, PRIMARY KEY(broker_id, note_id))');
        $this->addSql('CREATE INDEX IDX_54068BB26CC064FC ON broker_note (broker_id)');
        $this->addSql('CREATE INDEX IDX_54068BB226ED0855 ON broker_note (note_id)');
        $this->addSql('CREATE TABLE broker_supplier (broker_id INT NOT NULL, supplier_id INT NOT NULL, PRIMARY KEY(broker_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_C6F5157F6CC064FC ON broker_supplier (broker_id)');
        $this->addSql('CREATE INDEX IDX_C6F5157F2ADD6D8C ON broker_supplier (supplier_id)');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, city VARCHAR(120) DEFAULT NULL, country VARCHAR(120) DEFAULT NULL, phone VARCHAR(60) DEFAULT NULL, mobile VARCHAR(60) DEFAULT NULL, email VARCHAR(120) DEFAULT NULL, whatsapp VARCHAR(120) DEFAULT NULL, wechat VARCHAR(120) DEFAULT NULL, skype VARCHAR(120) DEFAULT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, contact_id INT DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, broker_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('CREATE TABLE customer_product (customer_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(customer_id, product_id))');
        $this->addSql('CREATE INDEX IDX_CF97A0139395C3F3 ON customer_product (customer_id)');
        $this->addSql('CREATE INDEX IDX_CF97A0134584665A ON customer_product (product_id)');
        $this->addSql('CREATE TABLE customer_message (customer_id INT NOT NULL, message_id INT NOT NULL, PRIMARY KEY(customer_id, message_id))');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('CREATE TABLE customer_note (customer_id INT NOT NULL, note_id INT NOT NULL, PRIMARY KEY(customer_id, note_id))');
        $this->addSql('CREATE INDEX IDX_9B2C5E639395C3F3 ON customer_note (customer_id)');
        $this->addSql('CREATE INDEX IDX_9B2C5E6326ED0855 ON customer_note (note_id)');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, text TEXT NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, sent_by VARCHAR(120) DEFAULT NULL, date_sent DATE DEFAULT NULL, broker_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE note (id INT NOT NULL, details TEXT DEFAULT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, broker_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, specifications_id INT NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, broker_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('CREATE TABLE product_note (product_id INT NOT NULL, note_id INT NOT NULL, PRIMARY KEY(product_id, note_id))');
        $this->addSql('CREATE INDEX IDX_4255D8B54584665A ON product_note (product_id)');
        $this->addSql('CREATE INDEX IDX_4255D8B526ED0855 ON product_note (note_id)');
        $this->addSql('CREATE TABLE specification (id INT NOT NULL, details TEXT NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE supplier (id INT NOT NULL, contact_id INT DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL, broker_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('CREATE TABLE supplier_product (supplier_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(supplier_id, product_id))');
        $this->addSql('CREATE INDEX IDX_522F70B22ADD6D8C ON supplier_product (supplier_id)');
        $this->addSql('CREATE INDEX IDX_522F70B24584665A ON supplier_product (product_id)');
        $this->addSql('CREATE TABLE supplier_message (supplier_id INT NOT NULL, message_id INT NOT NULL, PRIMARY KEY(supplier_id, message_id))');
        $this->addSql('CREATE INDEX IDX_37D844602ADD6D8C ON supplier_message (supplier_id)');
        $this->addSql('CREATE INDEX IDX_37D84460537A1329 ON supplier_message (message_id)');
        $this->addSql('CREATE TABLE supplier_note (supplier_id INT NOT NULL, note_id INT NOT NULL, PRIMARY KEY(supplier_id, note_id))');
        $this->addSql('CREATE INDEX IDX_2E50CFD2ADD6D8C ON supplier_note (supplier_id)');
        $this->addSql('CREATE INDEX IDX_2E50CFD26ED0855 ON supplier_note (note_id)');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INT NOT NULL, post_id INT NOT NULL, author_id INT NOT NULL, content TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post (id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
        $this->addSql('CREATE TABLE symfony_demo_tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D5855405E237E06 ON symfony_demo_tag (name)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, broker_id INT DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E96CC064FC ON users (broker_id)');
        $this->addSql('ALTER TABLE broker ADD CONSTRAINT FK_F6AAF03BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_message ADD CONSTRAINT FK_1DF33856CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_message ADD CONSTRAINT FK_1DF3385537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_customer ADD CONSTRAINT FK_DCE6F7086CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_customer ADD CONSTRAINT FK_DCE6F7089395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_note ADD CONSTRAINT FK_54068BB26CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_note ADD CONSTRAINT FK_54068BB226ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_supplier ADD CONSTRAINT FK_C6F5157F6CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE broker_supplier ADD CONSTRAINT FK_C6F5157F2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_product ADD CONSTRAINT FK_CF97A0139395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_product ADD CONSTRAINT FK_CF97A0134584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_message ADD CONSTRAINT FK_AA6094C19395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_message ADD CONSTRAINT FK_AA6094C1537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_note ADD CONSTRAINT FK_9B2C5E639395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_note ADD CONSTRAINT FK_9B2C5E6326ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBDE4EC11 FOREIGN KEY (specifications_id) REFERENCES specification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_note ADD CONSTRAINT FK_4255D8B54584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_note ADD CONSTRAINT FK_4255D8B526ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_product ADD CONSTRAINT FK_522F70B22ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_product ADD CONSTRAINT FK_522F70B24584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_message ADD CONSTRAINT FK_37D844602ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_message ADD CONSTRAINT FK_37D84460537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_note ADD CONSTRAINT FK_2E50CFD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplier_note ADD CONSTRAINT FK_2E50CFD26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_post ADD CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E96CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE broker_message DROP CONSTRAINT FK_1DF33856CC064FC');
        $this->addSql('ALTER TABLE broker_customer DROP CONSTRAINT FK_DCE6F7086CC064FC');
        $this->addSql('ALTER TABLE broker_note DROP CONSTRAINT FK_54068BB26CC064FC');
        $this->addSql('ALTER TABLE broker_supplier DROP CONSTRAINT FK_C6F5157F6CC064FC');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E96CC064FC');
        $this->addSql('ALTER TABLE broker DROP CONSTRAINT FK_F6AAF03BE7A1254A');
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09E7A1254A');
        $this->addSql('ALTER TABLE supplier DROP CONSTRAINT FK_9B2A6C7EE7A1254A');
        $this->addSql('ALTER TABLE broker_customer DROP CONSTRAINT FK_DCE6F7089395C3F3');
        $this->addSql('ALTER TABLE customer_product DROP CONSTRAINT FK_CF97A0139395C3F3');
        $this->addSql('ALTER TABLE customer_message DROP CONSTRAINT FK_AA6094C19395C3F3');
        $this->addSql('ALTER TABLE customer_note DROP CONSTRAINT FK_9B2C5E639395C3F3');
        $this->addSql('ALTER TABLE broker_message DROP CONSTRAINT FK_1DF3385537A1329');
        $this->addSql('ALTER TABLE customer_message DROP CONSTRAINT FK_AA6094C1537A1329');
        $this->addSql('ALTER TABLE supplier_message DROP CONSTRAINT FK_37D84460537A1329');
        $this->addSql('ALTER TABLE broker_note DROP CONSTRAINT FK_54068BB226ED0855');
        $this->addSql('ALTER TABLE customer_note DROP CONSTRAINT FK_9B2C5E6326ED0855');
        $this->addSql('ALTER TABLE product_note DROP CONSTRAINT FK_4255D8B526ED0855');
        $this->addSql('ALTER TABLE supplier_note DROP CONSTRAINT FK_2E50CFD26ED0855');
        $this->addSql('ALTER TABLE customer_product DROP CONSTRAINT FK_CF97A0134584665A');
        $this->addSql('ALTER TABLE product_note DROP CONSTRAINT FK_4255D8B54584665A');
        $this->addSql('ALTER TABLE supplier_product DROP CONSTRAINT FK_522F70B24584665A');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADBDE4EC11');
        $this->addSql('ALTER TABLE broker_supplier DROP CONSTRAINT FK_C6F5157F2ADD6D8C');
        $this->addSql('ALTER TABLE supplier_product DROP CONSTRAINT FK_522F70B22ADD6D8C');
        $this->addSql('ALTER TABLE supplier_message DROP CONSTRAINT FK_37D844602ADD6D8C');
        $this->addSql('ALTER TABLE supplier_note DROP CONSTRAINT FK_2E50CFD2ADD6D8C');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP CONSTRAINT FK_53AD8F834B89032C');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP CONSTRAINT FK_6ABC1CC44B89032C');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP CONSTRAINT FK_6ABC1CC4BAD26311');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP CONSTRAINT FK_53AD8F83F675F31B');
        $this->addSql('ALTER TABLE symfony_demo_post DROP CONSTRAINT FK_58A92E65F675F31B');
        $this->addSql('DROP SEQUENCE broker_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE note_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE specification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE supplier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE symfony_demo_comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE symfony_demo_post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE symfony_demo_tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE broker');
        $this->addSql('DROP TABLE broker_message');
        $this->addSql('DROP TABLE broker_customer');
        $this->addSql('DROP TABLE broker_note');
        $this->addSql('DROP TABLE broker_supplier');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_product');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('DROP TABLE customer_note');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_note');
        $this->addSql('DROP TABLE specification');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE supplier_product');
        $this->addSql('DROP TABLE supplier_message');
        $this->addSql('DROP TABLE supplier_note');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_tag');
        $this->addSql('DROP TABLE users');
    }
}
