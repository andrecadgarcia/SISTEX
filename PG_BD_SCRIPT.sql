-- -----------------------------------------------
-- Name: email
-- -----------------------------------------------

CREATE SEQUENCE email_id_email_seq;

CREATE TABLE email (
 id_email integer NOT NULL DEFAULT nextval('email_id_email_seq'),
 message text NOT NULL
);
ALTER TABLE ONLY email
 ADD CONSTRAINT email_pkey PRIMARY KEY (id_email);

ALTER SEQUENCE email_id_email_seq OWNED BY email.id_email;
 
-- -------------------------------------------------
-- Name: country
-- -------------------------------------------------

CREATE SEQUENCE country_id_country_seq;

CREATE TABLE country (
 id_country integer NOT NULL DEFAULT nextval('country_id_country_seq'),
 name character varying(50) NOT NULL
);
ALTER TABLE ONLY country
 ADD CONSTRAINT country_pkey PRIMARY KEY (id_country);

ALTER SEQUENCE country_id_country_seq OWNED BY country.id_country;

-- ----------------------------------------------
-- Name: state
-- ----------------------------------------------

CREATE SEQUENCE state_id_state_seq;

CREATE TABLE state (
 id_state integer NOT NULL DEFAULT nextval('state_id_state_seq'),
 id_country integer NOT NULL,
 name character varying(50) NOT NULL,
 initials character varying(2) NOT NULL
);
ALTER TABLE ONLY state
 ADD CONSTRAINT state_pkey PRIMARY KEY (id_state),
 ADD CONSTRAINT state_id_country_fkey FOREIGN KEY (id_country) REFERENCES country(id_country);

ALTER SEQUENCE state_id_state_seq OWNED BY state.id_state;

-- -------------------------------------------
-- Name: city
-- -------------------------------------------

CREATE SEQUENCE city_id_city_seq;

CREATE TABLE city (
 id_city integer NOT NULL DEFAULT nextval('city_id_city_seq'),
 id_state integer NOT NULL,
 name character varying(50) NOT NULL
);
ALTER TABLE ONLY city
 ADD CONSTRAINT city_pkey PRIMARY KEY (id_city),
 ADD CONSTRAINT city_id_state_fkey FOREIGN KEY (id_state) REFERENCES state(id_state);

ALTER SEQUENCE city_id_city_seq OWNED BY city.id_city;
 
-- -------------------------------------------------
-- Name: journal
-- -------------------------------------------------

CREATE SEQUENCE journal_id_journal_seq;

CREATE TABLE journal (
 id_journal integer NOT NULL DEFAULT nextval('journal_id_journal_seq'),
 name character varying(50) NOT NULL,
 source_code text NOT NULL
);
ALTER TABLE ONLY journal
 ADD CONSTRAINT journal_pkey PRIMARY KEY (id_journal);
 
ALTER SEQUENCE journal_id_journal_seq OWNED BY journal.id_journal;

-- -----------------------------------------
-- Name: article
-- -----------------------------------------

CREATE SEQUENCE article_id_article_seq;

CREATE TABLE article (
 id_article integer NOT NULL DEFAULT nextval('article_id_article_seq'),
 id_journal integer NOT NULL,
 titulo character varying(200) NOT NULL,
 ano numeric(4,0) NOT NULL,
 message character varying(50)
);
ALTER TABLE ONLY article
 ADD CONSTRAINT article_pkey PRIMARY KEY (id_article),
 ADD CONSTRAINT article_id_journal_fkey FOREIGN KEY (id_journal) REFERENCES journal(id_journal);

ALTER SEQUENCE article_id_article_seq OWNED BY article.id_article;

-- -------------------------------------------------
-- Name: log
-- -------------------------------------------------

CREATE SEQUENCE log_id_log_seq;

CREATE TABLE log (
 id_log integer NOT NULL DEFAULT nextval('log_id_log_seq'),
 id_article integer NOT NULL,
 message text NOT NULL,
 data date NOT NULL
);

ALTER TABLE ONLY log
 ADD CONSTRAINT log_pkey PRIMARY KEY (id_log),
 ADD CONSTRAINT log_id_article_fkey FOREIGN KEY (id_article) REFERENCES article(id_article);

ALTER SEQUENCE log_id_log_seq OWNED BY log.id_log;
 
-- --------------------------------------------------
-- Name: symbol
-- --------------------------------------------------

CREATE SEQUENCE symbol_id_symbol_seq;

CREATE TABLE symbol (
 id_symbol integer NOT NULL DEFAULT nextval('symbol_id_symbol_seq'),
 name character varying(10) NOT NULL,
 image bytea NOT NULL,
 source_code character varying(20) NOT NULL
);
ALTER TABLE ONLY symbol
 ADD CONSTRAINT symbol_pkey PRIMARY KEY (id_symbol);
 
ALTER SEQUENCE symbol_id_symbol_seq OWNED BY symbol.id_symbol;

-- --------------------------------------------------
-- Name: university
-- --------------------------------------------------

CREATE SEQUENCE university_id_university_seq;

CREATE TABLE university (
 id_university integer NOT NULL DEFAULT nextval('university_id_university_seq'),
 id_city integer NOT NULL,
 name character varying(100) NOT NULL,
 address character varying(100),
 zip_code character varying(11) NOT NULL,
 initials character varying(10)
);

ALTER TABLE ONLY university
 ADD CONSTRAINT university_pkey PRIMARY KEY (id_university),
 ADD CONSTRAINT university_id_city_fkey FOREIGN KEY (id_city) REFERENCES city(id_city);

ALTER SEQUENCE university_id_university_seq OWNED BY university.id_university; 
 
-- ---------------------------------------------
-- Name: department
-- ---------------------------------------------

CREATE SEQUENCE department_id_department_seq;

CREATE TABLE department (
 id_department integer NOT NULL DEFAULT nextval('department_id_department_seq'),
 id_university integer NOT NULL,
 name character varying(50) NOT NULL,
 initials character varying(10)
);

ALTER TABLE ONLY department
 ADD CONSTRAINT department_pkey PRIMARY KEY (id_department),
 ADD CONSTRAINT department_id_university_fkey FOREIGN KEY (id_university) REFERENCES university(id_university);

ALTER SEQUENCE department_id_department_seq OWNED BY department.id_department;  
 
-- ---------------------------------------------------
-- Name: author
-- ---------------------------------------------------

CREATE SEQUENCE author_id_author_seq;

CREATE TABLE author (
 id_author integer NOT NULL DEFAULT nextval('author_id_author_seq'),
 id_city integer NOT NULL,
 id_department integer NOT NULL,
 name character varying(100) NOT NULL,
 address character varying(100),
 id character varying(14) NOT NULL,
 foto bytea,
 email character varying(50) NOT NULL,
 password character varying(100) NOT NULL,
 permission character(1) NOT NULL
);
ALTER TABLE ONLY author
 ADD CONSTRAINT author_pkey PRIMARY KEY (id_author),
 ADD CONSTRAINT author_id_city_fkey FOREIGN KEY (id_city) REFERENCES city(id_city),
 ADD CONSTRAINT author_id_department_fkey FOREIGN KEY (id_department) REFERENCES department(id_department),
 ADD UNIQUE (email);

ALTER SEQUENCE author_id_author_seq OWNED BY author.id_author;  

-- --------------------------------------------------
-- Name: template
-- --------------------------------------------------

CREATE SEQUENCE template_id_template_seq;

CREATE TABLE template (
 id_template integer NOT NULL DEFAULT nextval('template_id_template_seq'),
 id_author integer NOT NULL,
 name character varying(50) NOT NULL,
 image bytea NOT NULL,
 source_code character varying(50) NOT NULL
);
ALTER TABLE ONLY template
 ADD CONSTRAINT template_pkey PRIMARY KEY (id_template),
 ADD CONSTRAINT template_id_author_fkey FOREIGN KEY (id_author) REFERENCES author(id_author);

ALTER SEQUENCE template_id_template_seq OWNED BY template.id_template;   
 
-- ---------------------------------------------
-- Name: contains_ts
-- ---------------------------------------------

CREATE TABLE contains_ts (
 id_template integer NOT NULL,
 id_symbol integer NOT NULL
);
ALTER TABLE ONLY contains_ts
 ADD CONSTRAINT contains_ts_id_template_fkey FOREIGN KEY (id_template) REFERENCES template(id_template),
 ADD CONSTRAINT contains_ts_id_symbol_fkey FOREIGN KEY (id_symbol) REFERENCES symbol(id_symbol);

-- -----------------------------------------------
-- Name: write_ua
-- -----------------------------------------------

CREATE TABLE write_aa (
 id_author integer NOT NULL,
 id_article integer NOT NULL
);

ALTER TABLE ONLY write_aa
 ADD CONSTRAINT write_aa_id_article_fkey FOREIGN KEY (id_article) REFERENCES article(id_article),
 ADD CONSTRAINT write_aa_id_author_fkey FOREIGN KEY (id_author) REFERENCES author(id_author);

-- -------------------------------------------------
-- Name: article_image
-- -------------------------------------------------

CREATE TABLE article_image (
 id_article integer NOT NULL,
 image character varying(50) NOT NULL
);
ALTER TABLE ONLY article_image
 ADD CONSTRAINT article_image_id_article_fkey FOREIGN KEY (id_article) REFERENCES article(id_article);

-- --------------------------------------------------
-- Name: author_phone
-- --------------------------------------------------

CREATE TABLE author_phone (
 id_author integer NOT NULL,
 phone character varying(17) NOT NULL
);
ALTER TABLE ONLY author_phone
 ADD CONSTRAINT author_phone_id_author_fkey FOREIGN KEY (id_author) REFERENCES author(id_author);
