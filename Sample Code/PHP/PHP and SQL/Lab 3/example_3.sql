/*Julia Litzsinger, 14144404, jjlnt8*/

/*starting statements*/
DROP SCHEMA IF EXISTS lab3 CASCADE;

CREATE SCHEMA lab3;

SET SEARCH_PATH = lab3;

/*create appropriate tables*/
CREATE TABLE customer ( 
   cust_id integer PRIMARY KEY,
   poc_name VARCHAR(50)
);

CREATE TABLE invoice (
   inv_no integer PRIMARY KEY,
   invoice_date date,
   inv_person_num integer REFERENCES customer(cust_id) ON DELETE CASCADE,
   street VARCHAR(50),
   city VARCHAR(50),
   state VARCHAR(2),
   zipcode integer
);

CREATE TABLE employee (
   employee_id integer PRIMARY KEY,
   first_name VARCHAR(50),
   last_name VARCHAR(50)
);

CREATE TABLE factory (
   factory_id integer PRIMARY KEY,
   phone_number VARCHAR(10),
   manager integer REFERENCES employee(employee_id)
);

CREATE TABLE product (
   product_id integer PRIMARY KEY,
   description VARCHAR(250),
   name VARCHAR(50)
);

CREATE TABLE factory_makes_product (
   factory_id integer REFERENCES factory(factory_id),
   product_id integer REFERENCES product,
   PRIMARY KEY (factory_id, product_id)
);

CREATE TABLE invoiceLine (
   line_number integer NOT NULL,
   quantity integer,
   unit_price integer,
   inv_no integer REFERENCES invoice ON DELETE CASCADE,
   inv_about_product_id integer REFERENCES product(product_id),
   PRIMARY KEY (inv_no, line_number, inv_about_product_id)
);

/*insert values into customer*/
INSERT INTO customer VALUES ('1234','whatisthis');
INSERT INTO customer VALUES ('2345', 'ireallywishiknew');
INSERT INTO customer VALUES ('3456', 'sadlyidont');

/*insert values into invoice*/
INSERT INTO invoice VALUES ('1111', '1/2/99', '1234', 'Walnut', 'CloudCity', 'MO','65201');
INSERT INTO invoice VALUES ('2222','2/13/65','1234','Walnut', 'CloudCity','MO','65201');
INSERT INTO invoice VALUES ('3333','5/23/98','2345','Elm','Oasis','KA','89341');

/*insert values into employee*/
INSERT INTO employee VALUES ('23','Charles', 'Dukino');
INSERT INTO employee VALUES ('14','Lileth', 'Firehawk');
INSERT INTO employee VALUES ('65','Roland', 'Crimson');

/*insert values into factory*/
INSERT INTO factory VALUES ('1','4320009999','23');
INSERT INTO factory VALUES ('2','7658880000','14');
INSERT INTO factory VALUES ('3','2223334444','65');

/*insert values into product*/
INSERT INTO product VALUES ('988','a golden pot','Pot');
INSERT INTO product VALUES ('455','a long rod make of steel','Rod');
INSERT INTO product VALUES ('322','a wooden bucket','Bucket');

/*insert values into factory_makes_product*/
INSERT INTO factory_makes_product VALUES ('3','455');
INSERT INTO factory_makes_product VALUES ('1','322');
INSERT INTO factory_makes_product VALUES ('2','988');

/*insert values into invoiceLine */
INSERT INTO invoiceLine VALUES ('9','55','12','1111','322');
INSERT INTO invoiceLine VALUES ('8','2','800','3333','988');
INSERT INTO invoiceLINE VALUES ('7','6','25','2222','455');
