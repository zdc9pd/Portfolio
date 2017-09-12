DROP SCHEMA IF EXISTS TonysPizza CASCADE;
CREATE SCHEMA TonysPizza;

SET search_path = TonysPizza, public;

--
-- Table structures
--

DROP TABLE IF EXISTS appetizers;
CREATE TABLE appetizers (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(250) default '',
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS crust;
CREATE TABLE crust(
	id SERIAL PRIMARY KEY,
	crustType varchar(20) NOT NULL default 'thin crust'
);

DROP TABLE IF EXISTS size_pizza;
CREATE TABLE size_pizza(
	id SERIAL PRIMARY KEY,
	crust_size int NOT NULL,
	size_price float(6) NOT NULL,
	topping_price float(4) NOT NULL
);

DROP TABLE IF EXISTS toppings;
CREATE TABLE toppings(
	id SERIAL PRIMARY KEY,
	toppings VARCHAR(30)
); 
DROP TABLE IF EXISTS specialtyPizza;
CREATE TABLE specialtyPizza(
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(250) default '',
	pizzaSize int NOT NULL,
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS dinners;
CREATE TABLE dinners(
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(250) NOT NULL default '',
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS sandwiches;
CREATE TABLE sandwiches (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(250) NOT NULL default '',
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS sides;
CREATE TABLE sides (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS salads;
CREATE TABLE salads(
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(250) NOT NULL default '',
	saladSize varchar(10) NOT NULL,
	price float(4) NOT NULL
);

DROP TABLE IF EXISTS drinks;
CREATE TABLE drinks (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	price float(4) NOT NULL
);

--
--INSERT values into appetizers
--

INSERT INTO appetizers VALUES (default,'Onion Rings', 'Breaded and deep fried generous portion', 3.95);
INSERT INTO appetizers VALUES (default,'Fried Mushrooms', 'Generous portion golden and deep fried', 7.25);
INSERT INTO appetizers VALUES (default,'Mozzarella Cheese Sticks', 'Eight cheese sticks served with marinara', 7.25);
INSERT INTO appetizers VALUES (default,'Spicy Buffalo Wings', 'Ten spicy wings served with ranch dressing', 7.25);
INSERT INTO appetizers VALUES (default,'Toasted Beef Ravioli', 'Twelve ravioli served with marinara', 7.25);

--
--INSERT values into crust
--

INSERT INTO crust VALUES (default,'thin crust');

--
--INSERT values into size_pizza
--
INSERT INTO size_pizza VALUES(default, 10, 10.95, 1.20);
INSERT INTO size_pizza VALUES(default, 12, 12.65, 1.50);
INSERT INTO size_pizza VALUES(default, 14, 14.45, 1.75);

--
--INSERT values into toppings
--
INSERT INTO toppings VALUES(default, 'onion');
INSERT INTO toppings VALUES(default, 'mushroom');
INSERT INTO toppings VALUES(default, 'canadian bacon');
INSERT INTO toppings VALUES(default, 'sausage');
INSERT INTO toppings VALUES(default, 'beef');
INSERT INTO toppings VALUES(default, 'anchovies');
INSERT INTO toppings VALUES(default, 'pepperoni');
INSERT INTO toppings VALUES(default, 'bacon');
INSERT INTO toppings VALUES(default, 'pepperjack cheese');
INSERT INTO toppings VALUES(default, 'chicken');
INSERT INTO toppings VALUES(default, 'black olive');
INSERT INTO toppings VALUES(default, 'jalapeno');
INSERT INTO toppings VALUES(default, 'shrimp');
INSERT INTO toppings VALUES(default, 'salami');
INSERT INTO toppings VALUES(default, 'green peppers');
INSERT INTO toppings VALUES(default, 'pineapple');
INSERT INTO toppings VALUES(default, 'green olive');
INSERT INTO toppings VALUES(default, 'gyros meat');

--
--INSERT values into specialtyPizza
--

INSERT INTO specialtyPizza VALUES (default, 'Veggie', 'Onion, green peppers, mushrooms, black olives', 10, 13.45);
INSERT INTO specialtyPizza VALUES (default, 'Veggie', 'Onion, green peppers, mushrooms, black olives', 12, 15.40);
INSERT INTO specialtyPizza VALUES (default, 'Veggie', 'Onion, green peppers, mushrooms, black olives', 14, 17.45);
INSERT INTO specialtyPizza VALUES (default, 'Meat Lovers', 'Pepperoni, beef, canadian bacon, sausage', 10, 14.20);
INSERT INTO specialtyPizza VALUES (default, 'Meat Lovers', 'Pepperoni, beef, canadian bacon, sausage', 12, 16.40);
INSERT INTO specialtyPizza VALUES (default, 'Meat Lovers', 'Pepperoni, beef, canadian bacon, sausage', 14, 18.65);
INSERT INTO specialtyPizza VALUES (default, 'Tonys Special', 'Sausage, onion, green pepper', 10, 12.70);
INSERT INTO specialtyPizza VALUES (default, 'Tonys Special', 'Sausage, onion, green pepper', 12, 13.95);
INSERT INTO specialtyPizza VALUES (default, 'Tonys Special', 'Sausage, onion, green pepper', 14, 15.65);
INSERT INTO specialtyPizza VALUES (default, 'House Special', 'Onion, green pepper, mushrooms, pepperoni, beef, canadian bacon, sausage', 10, 14.95);
INSERT INTO specialtyPizza VALUES (default, 'House Special', 'Onion, green pepper, mushrooms, pepperoni, beef, canadian bacon, sausage', 12, 17.35);
INSERT INTO specialtyPizza VALUES (default, 'House Special', 'Onion, green pepper, mushrooms, pepperoni, beef, canadian bacon, sausage', 14, 19.75);
INSERT INTO specialtyPizza VALUES (default, 'The Zeus', 'Lots of onion, green peppers, tomato, feta, gyro meat', 10, 14.70);
INSERT INTO specialtyPizza VALUES (default, 'The Zeus', 'Lots of onion, green peppers, tomato, feta, gyro meat', 12, 16.95);
INSERT INTO specialtyPizza VALUES (default, 'The Zeus', 'Lots of onion, green peppers, tomato, feta, gyro meat', 14, 19.45);

--
--INSERT values into dinners
--

INSERT INTO dinners VALUES (default,'Gyros Dinner', 'Tender gyros meat on pita served with french fries and a greek salad', 12.75);
INSERT INTO dinners VALUES (default,'Souvlaki Dinner', 'Marinated pork served on pita with french fries and a greek salad', 12.75);
INSERT INTO dinners VALUES (default,'Shrimp Dinner', 'Eight pieces of fried shrimp served with french fries and a tossed salad', 9.75);
INSERT INTO dinners VALUES (default,'Chicken Strip Dinner', 'Five chicken tenders served with french fries and a tossed salad', 8.75);
INSERT INTO dinners VALUES (default,'Spaghetti Dinner', 'Served with meat sauce, texas toast, and a tossed salad', 8.25);

--
--INSERT values into sandwiches
--

INSERT INTO sandwiches VALUES (default,'Gyros', 'Served on pita with onion, tomato, and tzaziki sauce', 6.95);
INSERT INTO sandwiches VALUES (default,'Souvlaki', 'Marinated pork served on pita with tomato, onion, and tzaziki sauce', 6.95);
INSERT INTO sandwiches VALUES (default,'Sub Sandwiches', 'Choice of ham, roast beef, or salami served on a hoagie with american cheese and mayo (.50 for additional meat or combinations)', 4.25);

--
--INSERT values into sides
--

INSERT INTO sides VALUES (default,'Gyros meat', 5.95);
INSERT INTO sides VALUES (default,'French fries', 1.95);
INSERT INTO sides VALUES (default,'Spanakopita', 3.95);
INSERT INTO sides VALUES (default,'Onion Rings', 3.95);
INSERT INTO sides VALUES (default,'Cheesecake', 2.50);
INSERT INTO sides VALUES (default,'Baklava', 2.50);

--
--INSERT values into salads
--

INSERT INTO salads VALUES (default, 'Greek Salad', 'Lettuce, tomato, onion, feta cheese, greek olives, greek dressing', 'Small', 5.95);
INSERT INTO salads VALUES (default, 'Greek Salad', 'Lettuce, tomato, onion, feta cheese, greek olives, greek dressing', 'Large', 6.95);
INSERT INTO salads VALUES (default, 'Chef Salad', 'Lettuce, tomato, ham, salami, american cheese', 'Small', 5.95);
INSERT INTO salads VALUES (default, 'Chef Salad', 'Lettuce, tomato, ham, salami, american cheese', 'Large', 6.95);
INSERT INTO salads VALUES (default, 'Tossed Salad', 'Lettuce, tomato, shredded cheese, and dressing of your choice', 'Small', 3.95);
INSERT INTO salads VALUES (default, 'Tossed Salad', 'Lettuce, tomato, shredded cheese, and dressing of your choice', 'Large', 4.95);

--
--INSERT values into drinks
--

INSERT INTO drinks VALUES (default,'Fountain Drinks', 1.95);
INSERT INTO drinks VALUES (default,'Soda Pitcher', 4.25);
INSERT INTO drinks VALUES (default,'Bottle Drinks', 1.65);
