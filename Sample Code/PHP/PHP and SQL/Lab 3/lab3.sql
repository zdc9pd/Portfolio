/*Zac Crane : 14151501  */

DROP SCHEMA IF EXISTS lab3 CASCADE;
CREATE SCHEMA lab3;
SET SEARCH_PATH = lab3;

/* Table creation  */

CREATE TABLE building (
	name VARCHAR(50),
	address VARCHAR(50),
	city VARCHAR(50),
	state_loc VARCHAR(50),
	zip integer,
	PRIMARY KEY (address,zip)
);

CREATE TABLE office (
	room_number integer PRIMARY KEY,
	waiting_room_capacity integer,
	location varchar(50),
	office_zip integer,
	FOREIGN KEY (location, office_zip) REFERENCES building
);

CREATE TABLE doctor (
	first_name VARCHAR(50),
	last_name VARCHAR(50),
	medical_license_num integer PRIMARY KEY,
	office_num integer, 
	FOREIGN KEY (office_num) REFERENCES office(room_number)	
);

CREATE TABLE patient (
	fname VARCHAR(50),
	lname VARCHAR(50),
	ssn VARCHAR(12) PRIMARY KEY
);

CREATE TABLE insurance (
	policy_num integer,
	insurer VARCHAR(50),
	patient_ssn VARCHAR(12) PRIMARY KEY REFERENCES patient ON DELETE CASCADE
);



CREATE TABLE appointment (
	appt_date date,
	appt_time integer,
	patient_ssn VARCHAR(12) REFERENCES patient,
	doctor_who integer REFERENCES doctor,
	PRIMARY KEY (appt_date, appt_time)
);

CREATE TABLE condition (
	icd10 VARCHAR(3) PRIMARY KEY,
	description VARCHAR(50),
	patient_ssn VARCHAR(12) REFERENCES patient
);

CREATE TABLE labwork (
	test_name VARCHAR(50),
	test_value boolean,
	test_timestamp integer,
	patient_ssn VARCHAR(12) REFERENCES patient,
	PRIMARY KEY (test_name, test_timestamp)
);

/* INSERT area */


/* Building */
INSERT INTO building VALUES('Doe_Center','123 Simpleton lane','Lawrence','KS','12345');
INSERT INTO building VALUES('Smith_Center','321 Superior lane','Columbia','MO','65202');
INSERT INTO building VALUES('Done_Center','123 Inferior AVE','Topeka','KS','55543');

/* Office */
INSERT INTO office VALUES('1','20','123 Simpleton lane','12345');
INSERT INTO office VALUES('2','12','321 Superior lane','65202');
INSERT INTO office VALUES('3','8','123 Inferior AVE','55543');

/* Doctor */
INSERT INTO doctor VALUES('John','Doe','1212','1');
INSERT INTO doctor VALUES('Joe','Smith','1358','2');
INSERT INTO doctor VALUES('Jim','Done','1414','3');

/* Patient */
INSERT INTO patient VALUES('Little','Timmy','123-45-678');
INSERT INTO patient VALUES('Poor','Guy','987-65-432');
INSERT INTO patient VALUES('Mighty','Max','123-98-765');

/* Insurance */
INSERT INTO insurance VALUES('1284','Goners','123-45-678');
INSERT INTO insurance VALUES('1285','Goners','987-65-432');
INSERT INTO insurance VALUES('34','Good Shield','123-98-765');

/* Appointment */
INSERT INTO appointment VALUES('10/20/2014','1600','123-45-678','1212');
INSERT INTO appointment VALUES('9/25/2014','1500','987-65-432','1358');
INSERT INTO appointment VALUES('11/10/2014','1300','123-98-765','1414');

/* Condition */
INSERT INTO condition VALUES('I00','Heart Disease','123-45-678');
INSERT INTO condition VALUES('V01','Patient is deceased','987-65-432');
INSERT INTO condition VALUES('S00','Missing Finger','123-98-765');

/* Lab work */
INSERT INTO labwork VALUES('Heart Test','TRUE','0900','123-45-678');
INSERT INTO labwork VALUES('Pulse Test','FALSE','1245','987-65-432');
INSERT INTO labwork VALUES('Blood Test','FALSE','1600','123-98-765');



