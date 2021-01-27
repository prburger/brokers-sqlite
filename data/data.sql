--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: _broker; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._broker (
    id smallint,
    contact_id smallint,
    name character varying(16) DEFAULT NULL::character varying,
    date_added character varying(1) DEFAULT NULL::character varying,
    date_edited character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._broker OWNER TO rebasedata;

--
-- Name: _broker_customer; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._broker_customer (
    broker_id smallint,
    customer_id smallint
);


ALTER TABLE public._broker_customer OWNER TO rebasedata;

--
-- Name: _broker_message; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._broker_message (
    broker_id smallint,
    message_id smallint
);


ALTER TABLE public._broker_message OWNER TO rebasedata;

--
-- Name: _broker_note; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._broker_note (
    broker_id smallint,
    note_id smallint
);


ALTER TABLE public._broker_note OWNER TO rebasedata;

--
-- Name: _broker_supplier; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._broker_supplier (
    broker_id smallint,
    supplier_id smallint
);


ALTER TABLE public._broker_supplier OWNER TO rebasedata;

--
-- Name: _contact; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._contact (
    id smallint,
    city character varying(10) DEFAULT NULL::character varying,
    country character varying(11) DEFAULT NULL::character varying,
    phone character varying(1) DEFAULT NULL::character varying,
    mobile character varying(1) DEFAULT NULL::character varying,
    email character varying(18) DEFAULT NULL::character varying,
    whatsapp character varying(1) DEFAULT NULL::character varying,
    wechat character varying(1) DEFAULT NULL::character varying,
    skype character varying(1) DEFAULT NULL::character varying,
    date_added character varying(1) DEFAULT NULL::character varying,
    date_edited character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._contact OWNER TO rebasedata;

--
-- Name: _customer; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._customer (
    id smallint,
    contact_id smallint,
    name character varying(15) DEFAULT NULL::character varying,
    date_added character varying(1) DEFAULT NULL::character varying,
    date_edited character varying(1) DEFAULT NULL::character varying,
    broker_id character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._customer OWNER TO rebasedata;

--
-- Name: _customer_message; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._customer_message (
    customer_id smallint,
    message_id smallint
);


ALTER TABLE public._customer_message OWNER TO rebasedata;

--
-- Name: _customer_note; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._customer_note (
    customer_id smallint,
    note_id smallint
);


ALTER TABLE public._customer_note OWNER TO rebasedata;

--
-- Name: _customer_product; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._customer_product (
    customer_id smallint,
    product_id smallint
);


ALTER TABLE public._customer_product OWNER TO rebasedata;

--
-- Name: _doctrine_migration_versions; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._doctrine_migration_versions (
    version character varying(40) DEFAULT NULL::character varying,
    executed_at character varying(1) DEFAULT NULL::character varying,
    execution_time smallint
);


ALTER TABLE public._doctrine_migration_versions OWNER TO rebasedata;

--
-- Name: _product; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._product (
    id smallint,
    specifications_id smallint,
    name character varying(13) DEFAULT NULL::character varying,
    date_added character varying(1) DEFAULT NULL::character varying,
    date_edited character varying(1) DEFAULT NULL::character varying,
    broker_id smallint
);


ALTER TABLE public._product OWNER TO rebasedata;

--
-- Name: _product_note; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._product_note (
    product_id character varying(1) DEFAULT NULL::character varying,
    note_id character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._product_note OWNER TO rebasedata;

--
-- Name: _sqlite_sequence; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._sqlite_sequence (
    name character varying(20) DEFAULT NULL::character varying,
    seq smallint
);


ALTER TABLE public._sqlite_sequence OWNER TO rebasedata;

--
-- Name: _supplier; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._supplier (
    id smallint,
    contact_id smallint,
    name character varying(24) DEFAULT NULL::character varying,
    date_added character varying(1) DEFAULT NULL::character varying,
    date_edited character varying(1) DEFAULT NULL::character varying,
    broker_id character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._supplier OWNER TO rebasedata;

--
-- Name: _supplier_message; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._supplier_message (
    supplier_id smallint,
    message_id smallint
);


ALTER TABLE public._supplier_message OWNER TO rebasedata;

--
-- Name: _supplier_note; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._supplier_note (
    supplier_id smallint,
    note_id smallint
);


ALTER TABLE public._supplier_note OWNER TO rebasedata;

--
-- Name: _supplier_product; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._supplier_product (
    supplier_id smallint,
    product_id smallint
);


ALTER TABLE public._supplier_product OWNER TO rebasedata;

--
-- Name: _symfony_demo_post_tag; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._symfony_demo_post_tag (
    post_id smallint,
    tag_id smallint
);


ALTER TABLE public._symfony_demo_post_tag OWNER TO rebasedata;

--
-- Name: _symfony_demo_tag; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._symfony_demo_tag (
    id smallint,
    name character varying(11) DEFAULT NULL::character varying
);


ALTER TABLE public._symfony_demo_tag OWNER TO rebasedata;

--
-- Data for Name: _broker; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._broker (id, contact_id, name, date_added, date_edited) FROM stdin;
1	1	Peter Arnold		
2	6	Marvin the Robot		
3	7	Paul Burger		
4	5	Freda Carpenter		
5	3	Alice Copper		
\.


--
-- Data for Name: _broker_customer; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._broker_customer (broker_id, customer_id) FROM stdin;
1	3
\.


--
-- Data for Name: _broker_message; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._broker_message (broker_id, message_id) FROM stdin;
1	2
1	5
1	9
2	2
2	6
2	7
2	8
2	10
3	9
\.


--
-- Data for Name: _broker_note; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._broker_note (broker_id, note_id) FROM stdin;
1	2
\.


--
-- Data for Name: _broker_supplier; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._broker_supplier (broker_id, supplier_id) FROM stdin;
1	1
2	9
\.


--
-- Data for Name: _contact; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._contact (id, city, country, phone, mobile, email, whatsapp, wechat, skype, date_added, date_edited) FROM stdin;
1	Adelaide	Australia								
2	New York	USA								
3	New York	USA								
4	Perth	Australia								
5	Beirut	Lebanon								
6										
7	Adelaide	Australia								
8	Melbourne	Australia								
9	Rome	Italy								
10	Houston	Texas								
11	Detroit	USA								
12	New York	USA								
13	Manchester	England								
14	London	England								
15	Sydney	Australia								
16	Darwin	Australia								
17	Adelaide	Australia			prburger@gmail.com					
18	Tokyo	Japan								
19	Melbourne	Aus								
20	Sydney	Australia								
21	Auckland	New Zealand								
22	Hubei	China								
23	Clare	Australia								
24										
\.


--
-- Data for Name: _customer; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._customer (id, contact_id, name, date_added, date_edited, broker_id) FROM stdin;
2	3	Norman Mailer			
3	5	Ismail Amir			
4	8	Alan Davis			3
5	9	Martha Lambardo			3
6	10	Felix Umber			3
7	11	Fats Domino			5
8	12	Michael Keaton			5
9	13	Spike Milligan			5
10	14	Alvin Purple			5
11	15	Mel Gibson			5
12	16	Melaine Gibbs			5
\.


--
-- Data for Name: _customer_message; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._customer_message (customer_id, message_id) FROM stdin;
2	2
2	5
2	9
3	2
3	3
3	9
4	9
\.


--
-- Data for Name: _customer_note; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._customer_note (customer_id, note_id) FROM stdin;
3	3
\.


--
-- Data for Name: _customer_product; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._customer_product (customer_id, product_id) FROM stdin;
3	1
\.


--
-- Data for Name: _doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20210120094408		70
DoctrineMigrations\\Version20210120094415		179
DoctrineMigrations\\Version20210120234118		591
DoctrineMigrations\\Version20210120234138		328
DoctrineMigrations\\Version20210121004344		885
DoctrineMigrations\\Version20210121004353		295
DoctrineMigrations\\Version20210121011500		643
DoctrineMigrations\\Version20210121011508		282
DoctrineMigrations\\Version20210121012652		720
DoctrineMigrations\\Version20210121012700		280
DoctrineMigrations\\Version20210121025538		1007
DoctrineMigrations\\Version20210121025549		350
DoctrineMigrations\\Version20210121030910		731
DoctrineMigrations\\Version20210121030919		323
DoctrineMigrations\\Version20210121031241		782
DoctrineMigrations\\Version20210121031250		280
DoctrineMigrations\\Version20210121032029		77
DoctrineMigrations\\Version20210121032058		308
\.


--
-- Data for Name: _product; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._product (id, specifications_id, name, date_added, date_edited, broker_id) FROM stdin;
1	1	Product 1			2
2	2	Product 1qqq			3
3	3	Mulloway			2
4	4	Denim Fabric			2
5	5	Aftershave			2
6	6	Wine Glasses			2
7	7	Red bricks			2
8	8	Scrap coppper			2
\.


--
-- Data for Name: _product_note; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._product_note (product_id, note_id) FROM stdin;
\.


--
-- Data for Name: _sqlite_sequence; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._sqlite_sequence (name, seq) FROM stdin;
contact	24
note	4
message	10
symfony_demo_tag	9
specification	8
broker	5
customer	12
product	8
supplier	9
symfony_demo_comment	150
symfony_demo_post	30
users	5
\.


--
-- Data for Name: _supplier; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._supplier (id, contact_id, name, date_added, date_edited, broker_id) FROM stdin;
1	4	Worldwide Asian Foods			3
2	17	Mammoth Discounts			5
3	18	Global Seafood Suppliers			5
4	19	Autoparts			5
5	20	Easy Fabrics			5
6	21	Cadburys			2
7	22	Hubei Metal Exports			2
8	23	Penfold Wines			2
9	24	Marvin's supplier			
\.


--
-- Data for Name: _supplier_message; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._supplier_message (supplier_id, message_id) FROM stdin;
1	4
1	9
2	9
3	9
5	5
\.


--
-- Data for Name: _supplier_note; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._supplier_note (supplier_id, note_id) FROM stdin;
1	4
\.


--
-- Data for Name: _supplier_product; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._supplier_product (supplier_id, product_id) FROM stdin;
1	2
\.


--
-- Data for Name: _symfony_demo_post_tag; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._symfony_demo_post_tag (post_id, tag_id) FROM stdin;
1	3
1	4
1	6
1	7
2	1
2	3
2	5
2	7
3	3
3	4
3	9
4	4
4	5
5	3
5	7
5	8
6	4
6	8
7	4
7	5
7	7
8	3
8	8
9	3
9	4
9	7
9	9
10	3
10	8
10	9
11	2
11	6
11	9
12	1
12	2
12	5
12	8
13	1
13	8
14	1
14	6
15	1
15	5
15	9
16	3
16	5
16	6
17	1
17	4
18	2
18	4
18	6
18	9
19	1
19	3
19	5
19	7
20	1
20	5
20	7
20	8
21	3
21	4
21	8
22	2
22	3
22	6
23	4
23	7
23	8
23	9
24	1
24	8
25	3
25	6
25	9
26	3
26	7
26	9
27	1
27	9
28	3
28	5
29	5
29	8
30	1
30	2
30	6
\.


--
-- Data for Name: _symfony_demo_tag; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._symfony_demo_tag (id, name) FROM stdin;
4	adipiscing
3	consectetur
8	dolore
5	incididunt
2	ipsum
6	labore
1	lorem
9	pariatur
7	voluptate
\.


--
-- PostgreSQL database dump complete
--

