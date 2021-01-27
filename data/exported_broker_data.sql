BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "doctrine_migration_versions" (
	"version"	VARCHAR(191) NOT NULL,
	"executed_at"	DATETIME DEFAULT NULL,
	"execution_time"	INTEGER DEFAULT NULL,
	PRIMARY KEY("version")
);
CREATE TABLE IF NOT EXISTS "contact" (
	"id"	INTEGER NOT NULL,
	"city"	VARCHAR(120) DEFAULT NULL,
	"country"	VARCHAR(120) DEFAULT NULL,
	"phone"	VARCHAR(60) DEFAULT NULL,
	"mobile"	VARCHAR(60) DEFAULT NULL,
	"email"	VARCHAR(120) DEFAULT NULL,
	"whatsapp"	VARCHAR(120) DEFAULT NULL,
	"wechat"	VARCHAR(120) DEFAULT NULL,
	"skype"	VARCHAR(120) DEFAULT NULL,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "message" (
	"id"	INTEGER NOT NULL,
	"text"	CLOB NOT NULL,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	"sent_by"	VARCHAR(120) DEFAULT NULL,
	"date_sent"	DATE DEFAULT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "note" (
	"id"	INTEGER NOT NULL,
	"details"	CLOB DEFAULT NULL,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "specification" (
	"id"	INTEGER NOT NULL,
	"details"	CLOB NOT NULL,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "broker" (
	"id"	INTEGER NOT NULL,
	"contact_id"	INTEGER NOT NULL,
	"name"	VARCHAR(120) NOT NULL COLLATE BINARY,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	CONSTRAINT "FK_F6AAF03BE7A1254A" FOREIGN KEY("contact_id") REFERENCES "contact"("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "broker_message" (
	"broker_id"	INTEGER NOT NULL,
	"message_id"	INTEGER NOT NULL,
	PRIMARY KEY("broker_id","message_id"),
	CONSTRAINT "FK_1DF33856CC064FC" FOREIGN KEY("broker_id") REFERENCES "broker"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_1DF3385537A1329" FOREIGN KEY("message_id") REFERENCES "message"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "broker_customer" (
	"broker_id"	INTEGER NOT NULL,
	"customer_id"	INTEGER NOT NULL,
	PRIMARY KEY("broker_id","customer_id"),
	CONSTRAINT "FK_DCE6F7086CC064FC" FOREIGN KEY("broker_id") REFERENCES "broker"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_DCE6F7089395C3F3" FOREIGN KEY("customer_id") REFERENCES "customer"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "broker_note" (
	"broker_id"	INTEGER NOT NULL,
	"note_id"	INTEGER NOT NULL,
	PRIMARY KEY("broker_id","note_id"),
	CONSTRAINT "FK_54068BB26CC064FC" FOREIGN KEY("broker_id") REFERENCES "broker"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_54068BB226ED0855" FOREIGN KEY("note_id") REFERENCES "note"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "broker_supplier" (
	"broker_id"	INTEGER NOT NULL,
	"supplier_id"	INTEGER NOT NULL,
	PRIMARY KEY("broker_id","supplier_id"),
	CONSTRAINT "FK_C6F5157F6CC064FC" FOREIGN KEY("broker_id") REFERENCES "broker"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_C6F5157F2ADD6D8C" FOREIGN KEY("supplier_id") REFERENCES "supplier"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "customer" (
	"id"	INTEGER NOT NULL,
	"contact_id"	INTEGER DEFAULT NULL,
	"name"	VARCHAR(120) NOT NULL COLLATE BINARY,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	CONSTRAINT "FK_81398E09E7A1254A" FOREIGN KEY("contact_id") REFERENCES "contact"("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "customer_product" (
	"customer_id"	INTEGER NOT NULL,
	"product_id"	INTEGER NOT NULL,
	PRIMARY KEY("customer_id","product_id"),
	CONSTRAINT "FK_CF97A0139395C3F3" FOREIGN KEY("customer_id") REFERENCES "customer"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_CF97A0134584665A" FOREIGN KEY("product_id") REFERENCES "product"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "customer_message" (
	"customer_id"	INTEGER NOT NULL,
	"message_id"	INTEGER NOT NULL,
	PRIMARY KEY("customer_id","message_id"),
	CONSTRAINT "FK_AA6094C1537A1329" FOREIGN KEY("message_id") REFERENCES "message"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_AA6094C19395C3F3" FOREIGN KEY("customer_id") REFERENCES "customer"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "customer_note" (
	"customer_id"	INTEGER NOT NULL,
	"note_id"	INTEGER NOT NULL,
	PRIMARY KEY("customer_id","note_id"),
	CONSTRAINT "FK_9B2C5E639395C3F3" FOREIGN KEY("customer_id") REFERENCES "customer"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_9B2C5E6326ED0855" FOREIGN KEY("note_id") REFERENCES "note"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "product" (
	"id"	INTEGER NOT NULL,
	"specifications_id"	INTEGER NOT NULL,
	"name"	VARCHAR(120) NOT NULL COLLATE BINARY,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	CONSTRAINT "FK_D34A04ADBDE4EC11" FOREIGN KEY("specifications_id") REFERENCES "specification"("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "product_note" (
	"product_id"	INTEGER NOT NULL,
	"note_id"	INTEGER NOT NULL,
	PRIMARY KEY("product_id","note_id"),
	CONSTRAINT "FK_4255D8B54584665A" FOREIGN KEY("product_id") REFERENCES "product"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_4255D8B526ED0855" FOREIGN KEY("note_id") REFERENCES "note"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "supplier" (
	"id"	INTEGER NOT NULL,
	"contact_id"	INTEGER DEFAULT NULL,
	"name"	VARCHAR(120) NOT NULL COLLATE BINARY,
	"date_added"	DATE NOT NULL,
	"date_edited"	DATE NOT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	CONSTRAINT "FK_9B2A6C7EE7A1254A" FOREIGN KEY("contact_id") REFERENCES "contact"("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "supplier_product" (
	"supplier_id"	INTEGER NOT NULL,
	"product_id"	INTEGER NOT NULL,
	PRIMARY KEY("supplier_id","product_id"),
	CONSTRAINT "FK_522F70B22ADD6D8C" FOREIGN KEY("supplier_id") REFERENCES "supplier"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_522F70B24584665A" FOREIGN KEY("product_id") REFERENCES "product"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "supplier_message" (
	"supplier_id"	INTEGER NOT NULL,
	"message_id"	INTEGER NOT NULL,
	PRIMARY KEY("supplier_id","message_id"),
	CONSTRAINT "FK_37D84460537A1329" FOREIGN KEY("message_id") REFERENCES "message"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_37D844602ADD6D8C" FOREIGN KEY("supplier_id") REFERENCES "supplier"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "supplier_note" (
	"supplier_id"	INTEGER NOT NULL,
	"note_id"	INTEGER NOT NULL,
	PRIMARY KEY("supplier_id","note_id"),
	CONSTRAINT "FK_2E50CFD2ADD6D8C" FOREIGN KEY("supplier_id") REFERENCES "supplier"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
	CONSTRAINT "FK_2E50CFD26ED0855" FOREIGN KEY("note_id") REFERENCES "note"("id") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER NOT NULL,
	"broker_id"	INTEGER DEFAULT NULL,
	"username"	VARCHAR(255) NOT NULL,
	"password"	VARCHAR(255) NOT NULL,
	"full_name"	VARCHAR(255) DEFAULT NULL,
	"email"	VARCHAR(255) DEFAULT NULL,
	"roles"	CLOB NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	CONSTRAINT "FK_1483A5E96CC064FC" FOREIGN KEY("broker_id") REFERENCES "broker"("id") NOT DEFERRABLE INITIALLY IMMEDIATE
);
INSERT INTO "doctrine_migration_versions" ("version","executed_at","execution_time") VALUES ('DoctrineMigrations\Version20210120094408','2021-01-20 10:44:12',70),
 ('DoctrineMigrations\Version20210120094415','2021-01-20 10:44:20',179),
 ('DoctrineMigrations\Version20210120234118','2021-01-21 00:41:30',591),
 ('DoctrineMigrations\Version20210120234138','2021-01-21 00:41:47',328),
 ('DoctrineMigrations\Version20210121004344','2021-01-21 01:43:49',885),
 ('DoctrineMigrations\Version20210121004353','2021-01-21 01:44:01',295),
 ('DoctrineMigrations\Version20210121011500','2021-01-21 02:15:05',643),
 ('DoctrineMigrations\Version20210121011508','2021-01-21 02:15:16',282),
 ('DoctrineMigrations\Version20210121012652','2021-01-21 02:26:56',720),
 ('DoctrineMigrations\Version20210121012700','2021-01-21 02:27:09',280),
 ('DoctrineMigrations\Version20210121025538','2021-01-21 03:55:45',1007),
 ('DoctrineMigrations\Version20210121025549','2021-01-21 03:55:58',350),
 ('DoctrineMigrations\Version20210121030910','2021-01-21 04:09:16',731),
 ('DoctrineMigrations\Version20210121030919','2021-01-21 04:09:25',323),
 ('DoctrineMigrations\Version20210121031241','2021-01-21 04:12:47',782),
 ('DoctrineMigrations\Version20210121031250','2021-01-21 04:12:57',280),
 ('DoctrineMigrations\Version20210121032029','2021-01-21 04:20:55',77),
 ('DoctrineMigrations\Version20210121032058','2021-01-21 04:21:05',308);
INSERT INTO "contact" ("id","city","country","phone","mobile","email","whatsapp","wechat","skype","date_added","date_edited") VALUES (1,'Adelaide','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (2,'New York','USA',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (3,'New York','USA',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (4,'Perth','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (5,'Beirut','Lebanon',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (7,'Adelaide','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-20','2021-01-20'),
 (8,'Melbourne','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (9,'Rome','Italy',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (10,'Houston','Texas',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (11,'Detroit','USA',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (12,'New York','USA',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (13,'Manchester','England',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (14,'London','England',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (15,'Sydney','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (16,'Darwin','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (17,'Adelaide','Australia',NULL,NULL,'prburger@gmail.com',NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (18,'Tokyo','Japan',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (19,'Melbourne','Aus',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (20,'Sydney','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (21,'Auckland','New Zealand',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (22,'Hubei','China',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (23,'Clare','Australia',NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21'),
 (24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-21','2021-01-21');
INSERT INTO "message" ("id","text","date_added","date_edited","sent_by","date_sent","broker_id") VALUES (1,'mmmmmmm','2021-01-20','2021-01-20','Peter Arnold','2021-01-20',1),
 (2,'iiiiiiiiiiii','2021-01-20','2021-01-20','Marvin the Robot','2021-01-20',2),
 (3,'kkkkkkkkkkk','2021-01-20','2021-01-20','Ismail Amir','2021-01-20',3),
 (4,'iiiiiiiii','2021-01-20','2021-01-20','Worldwide Asian Foods','2021-01-20',3),
 (5,'lllllll','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',2),
 (6,'lkjhgfdsa','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',2),
 (7,'12qwaszx','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',2),
 (8,'12qwaszx','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',2),
 (9,'kkkkkkkkkkkkkk kkkkkkkkkk kkkkk','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',2),
 (10,'msdm sdms smds  msd msd','2021-01-21','2021-01-21','Marvin the Robot','2021-01-21',NULL);
INSERT INTO "note" ("id","details","date_added","date_edited","broker_id") VALUES (1,'notes for norman','2021-01-20','2021-01-20',2),
 (2,'hhhhhhhhhhh','2021-01-20','2021-01-20',2),
 (3,'kkkkkkkkkkkkk','2021-01-20','2021-01-20',3),
 (4,'iiiiiiiiiiiii','2021-01-20','2021-01-20',3);
INSERT INTO "specification" ("id","details","date_added","date_edited") VALUES (1,'Spec1','2021-01-20','2021-01-20'),
 (2,'yytyty6','2021-01-20','2021-01-20'),
 (3,'18 - 20kg','2021-01-21','2021-01-21'),
 (4,'Twill','2021-01-21','2021-01-21'),
 (5,'sweet musk','2021-01-21','2021-01-21'),
 (6,'flutes','2021-01-21','2021-01-21'),
 (7,'stone','2021-01-21','2021-01-21'),
 (8,'millberry','2021-01-21','2021-01-21');
INSERT INTO "broker" ("id","contact_id","name","date_added","date_edited") VALUES (1,1,'Peter Arnold','2021-01-20','2021-01-20'),
 (2,6,'Marvin the Robot','2021-01-20','2021-01-21'),
 (3,7,'Paul Burger','2021-01-20','2021-01-21'),
 (4,5,'Freda Carpenter','2021-01-01','2021-01-01'),
 (5,3,'Alice Copper','2021-01-01','2021-01-01');
INSERT INTO "broker_message" ("broker_id","message_id") VALUES (2,6),
 (2,7),
 (2,8),
 (2,10),
 (2,2),
 (1,2),
 (1,9),
 (3,9),
 (1,5);
INSERT INTO "broker_customer" ("broker_id","customer_id") VALUES (1,3);
INSERT INTO "broker_note" ("broker_id","note_id") VALUES (1,2);
INSERT INTO "broker_supplier" ("broker_id","supplier_id") VALUES (1,1),
 (2,9);
INSERT INTO "customer" ("id","contact_id","name","date_added","date_edited","broker_id") VALUES (2,3,'Norman Mailer','2021-01-20','2021-01-20',NULL),
 (3,5,'Ismail Amir','2021-01-20','2021-01-20',NULL),
 (4,8,'Alan Davis','2021-01-21','2021-01-21',3),
 (5,9,'Martha Lambardo','2021-01-21','2021-01-21',3),
 (6,10,'Felix Umber','2021-01-21','2021-01-21',3),
 (7,11,'Fats Domino','2021-01-21','2021-01-21',5),
 (8,12,'Michael Keaton','2021-01-21','2021-01-21',5),
 (9,13,'Spike Milligan','2021-01-21','2021-01-21',5),
 (10,14,'Alvin Purple','2021-01-21','2021-01-21',5),
 (11,15,'Mel Gibson','2021-01-21','2021-01-21',5),
 (12,16,'Melaine Gibbs','2021-01-21','2021-01-21',5);
INSERT INTO "customer_product" ("customer_id","product_id") VALUES (3,1);
INSERT INTO "customer_message" ("customer_id","message_id") VALUES (3,3),
 (2,2),
 (3,2),
 (2,9),
 (3,9),
 (4,9),
 (2,5);
INSERT INTO "customer_note" ("customer_id","note_id") VALUES (3,3);
INSERT INTO "product" ("id","specifications_id","name","date_added","date_edited","broker_id") VALUES (1,1,'Product 1','2021-01-20','2021-01-20',2),
 (2,2,'Product 1qqq','2021-01-20','2021-01-20',3),
 (3,3,'Mulloway','2021-01-21','2021-01-21',2),
 (4,4,'Denim Fabric','2021-01-21','2021-01-21',2),
 (5,5,'Aftershave','2021-01-21','2021-01-21',2),
 (6,6,'Wine Glasses','2021-01-21','2021-01-21',2),
 (7,7,'Red bricks','2021-01-21','2021-01-21',2),
 (8,8,'Scrap coppper','2021-01-21','2021-01-21',2);
INSERT INTO "supplier" ("id","contact_id","name","date_added","date_edited","broker_id") VALUES (1,4,'Worldwide Asian Foods','2021-01-20','2021-01-20',3),
 (2,17,'Mammoth Discounts','2021-01-21','2021-01-21',5),
 (3,18,'Global Seafood Suppliers','2021-01-21','2021-01-21',5),
 (4,19,'Autoparts','2021-01-21','2021-01-21',5),
 (5,20,'Easy Fabrics','2021-01-21','2021-01-21',5),
 (6,21,'Cadburys','2021-01-21','2021-01-21',2),
 (7,22,'Hubei Metal Exports','2021-01-21','2021-01-21',2),
 (8,23,'Penfold Wines','2021-01-21','2021-01-21',2),
 (9,24,'Marvin''s supplier','2021-01-21','2021-01-21',NULL);
INSERT INTO "supplier_product" ("supplier_id","product_id") VALUES (1,2);
INSERT INTO "supplier_message" ("supplier_id","message_id") VALUES (1,4),
 (1,9),
 (2,9),
 (3,9),
 (5,5);
INSERT INTO "supplier_note" ("supplier_id","note_id") VALUES (1,4);
INSERT INTO "users" ("id","broker_id","username","password","full_name","email","roles") VALUES (1,1,'parnold','$2y$13$IMalnQpo7xfZD5FJGbEadOcqyj2mi/NQbQiI8v2wBXfjZ4nwshJlG','Peter Arnold','parnold@symfony.com','["ROLE_ADMIN"]'),
 (2,4,'freda','$2y$13$m45IusIVHTcBoBQTBd/V.O5EuwOSIYNiuWnw0gsgo7XJDQwDJ83aC','Freda Carpenter','freda@symfony.com','["ROLE_ADMIN"]'),
 (3,5,'alice','$2y$13$236BEGW9Gnbmv.lfrkZLwujj0jSOYFsQ5dI90BqM9s2mZ9WbzJmzO','Alice Copper','alice@symfony.com','["ROLE_USER"]'),
 (4,2,'marvin','$argon2id$v=19$m=65536,t=4,p=1$F+WMYw6D+5iMO8sFyjNSTg$zmyTSWcnB2HCNpigJ3BLr3amMd6TKBwCKKnJFq4pMSk','Marvin the Robot','prburger@gmail.com','["ROLE_USER"]'),
 (5,3,'pburger','$argon2id$v=19$m=65536,t=4,p=1$0YG1ZBeoBhF73zjGe3ONsQ$6+X0j85/qQNOvsBg63GVOeRSnKYrzJYFG5500iEjDg4','Paul Burger','prburger@mail.com','["ROLE_ADMIN"]');
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_F6AAF03BE7A1254A" ON "broker" (
	"contact_id"
);
CREATE INDEX IF NOT EXISTS "IDX_1DF3385537A1329" ON "broker_message" (
	"message_id"
);
CREATE INDEX IF NOT EXISTS "IDX_1DF33856CC064FC" ON "broker_message" (
	"broker_id"
);
CREATE INDEX IF NOT EXISTS "IDX_DCE6F7089395C3F3" ON "broker_customer" (
	"customer_id"
);
CREATE INDEX IF NOT EXISTS "IDX_DCE6F7086CC064FC" ON "broker_customer" (
	"broker_id"
);
CREATE INDEX IF NOT EXISTS "IDX_54068BB226ED0855" ON "broker_note" (
	"note_id"
);
CREATE INDEX IF NOT EXISTS "IDX_54068BB26CC064FC" ON "broker_note" (
	"broker_id"
);
CREATE INDEX IF NOT EXISTS "IDX_C6F5157F2ADD6D8C" ON "broker_supplier" (
	"supplier_id"
);
CREATE INDEX IF NOT EXISTS "IDX_C6F5157F6CC064FC" ON "broker_supplier" (
	"broker_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_81398E09E7A1254A" ON "customer" (
	"contact_id"
);
CREATE INDEX IF NOT EXISTS "IDX_CF97A0134584665A" ON "customer_product" (
	"product_id"
);
CREATE INDEX IF NOT EXISTS "IDX_CF97A0139395C3F3" ON "customer_product" (
	"customer_id"
);
CREATE INDEX IF NOT EXISTS "IDX_AA6094C1537A1329" ON "customer_message" (
	"message_id"
);
CREATE INDEX IF NOT EXISTS "IDX_AA6094C19395C3F3" ON "customer_message" (
	"customer_id"
);
CREATE INDEX IF NOT EXISTS "IDX_9B2C5E6326ED0855" ON "customer_note" (
	"note_id"
);
CREATE INDEX IF NOT EXISTS "IDX_9B2C5E639395C3F3" ON "customer_note" (
	"customer_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_D34A04ADBDE4EC11" ON "product" (
	"specifications_id"
);
CREATE INDEX IF NOT EXISTS "IDX_4255D8B526ED0855" ON "product_note" (
	"note_id"
);
CREATE INDEX IF NOT EXISTS "IDX_4255D8B54584665A" ON "product_note" (
	"product_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_9B2A6C7EE7A1254A" ON "supplier" (
	"contact_id"
);
CREATE INDEX IF NOT EXISTS "IDX_522F70B24584665A" ON "supplier_product" (
	"product_id"
);
CREATE INDEX IF NOT EXISTS "IDX_522F70B22ADD6D8C" ON "supplier_product" (
	"supplier_id"
);
CREATE INDEX IF NOT EXISTS "IDX_37D84460537A1329" ON "supplier_message" (
	"message_id"
);
CREATE INDEX IF NOT EXISTS "IDX_37D844602ADD6D8C" ON "supplier_message" (
	"supplier_id"
);
CREATE INDEX IF NOT EXISTS "IDX_2E50CFD26ED0855" ON "supplier_note" (
	"note_id"
);
CREATE INDEX IF NOT EXISTS "IDX_2E50CFD2ADD6D8C" ON "supplier_note" (
	"supplier_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_1483A5E9F85E0677" ON "users" (
	"username"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_1483A5E9E7927C74" ON "users" (
	"email"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_1483A5E96CC064FC" ON "users" (
	"broker_id"
);
COMMIT;
