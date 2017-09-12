/*
Zac Crane
14151501
*/
SET SEARCH_PATH = lab5;

DROP VIEW IF EXISTS weight CASCADE;
DROP VIEW IF EXISTS BMI CASCADE;

/*Create View 1*/
CREATE VIEW weight AS 
SELECT p.pid, fname, lname
FROM person AS p
INNER JOIN body_composition AS b
ON (p.pid = b.pid) 
WHERE (weight > 140);

\echo output #1

SELECT *
FROM weight;

/*Creat view 2*/
CREATE VIEW BMI AS 
SELECT fname, lname, round(703 * (b.weight/(power(b.height,2.)))) AS BMI
FROM weight AS w  
INNER JOIN body_composition AS b
ON (w.pid = b.pid) 
WHERE (weight > 150);

\echo output #2

SELECT * 
FROM BMI;

\echo output #3

SELECT university_name, city 
FROM university 
WHERE NOT EXISTS (
	SELECT DISTINCT uid 
	FROM person 
	WHERE university.uid = person.uid
	);

\echo output #4

SELECT fname, lname 
FROM person 
WHERE uid 
IN (
	SELECT uid 
	FROM university 
	WHERE city = 'Columbia'
	);

\echo output #5

SELECT  activity_name
FROM activity 
WHERE activity_name 
NOT IN (
	SELECT DISTINCT activity_name 
	FROM participated_in
	);

\echo output #6

SELECT pid 
FROM participated_in 
WHERE (activity_name = 'running') 
UNION 
SELECT pid 
FROM participated_in
WHERE (activity_name = 'racquetball');

\echo output #7

SELECT fname, lname 
FROM person 
INNER JOIN body_composition 
ON person.pid = body_composition.pid 
WHERE body_composition.age > '30' 
INTERSECT 
SELECT fname, lname 
FROM person 
INNER JOIN body_composition 
ON person.pid = body_composition.pid 
WHERE body_composition.height > '65';

\echo output #8

SELECT p.fname, p.lname AS Last_Name, body.weight AS w, body.height AS h, body.age AS age 
FROM person AS p INNER JOIN body_composition AS body 
ON (p.pid = body.pid) 
ORDER BY h DESC, w ASC, Last_Name ASC; 


\echo output #9

WITH MU_student 
AS (
	SELECT pid, fname, lname 
	FROM person AS p 
	INNER JOIN university AS u 
	ON p.uid = u.uid 
	WHERE u.university_name = 'University of Missouri Columbia'
	) 
SELECT * 
FROM body_composition AS body 
INNER JOIN MU_student AS MU 
ON body.pid = MU.pid 
WHERE body.pid 
IN (
	SELECT pid 
	FROM MU_student
	);


\echo output #10

WITH new_stu 
AS (
	SELECT p.pid 
	FROM person AS p 
	INNER JOIN body_composition AS body 
	ON p.pid = body.pid 
	INNER JOIN university AS u 
	ON p.uid=u.uid 
	WHERE body.height > '70' AND p.uid != '2'
	) 
UPDATE person 
SET uid = 2 
WHERE person.pid 
IN (
	SELECT pid 
	FROM new_stu AS ns
	);
