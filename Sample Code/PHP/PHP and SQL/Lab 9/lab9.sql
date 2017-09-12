/*
Zac Crane
14151501
*/

--Query 1 Returns 2
SELECT name10 
FROM tl_2010_us_state10
WHERE ST_Intersects(coords, ST_SetSRID(ST_MakeBox2D(ST_Point(-110, 35), ST_Point(-109, 36)), 4326))
ORDER BY name10 ASC;

--Query 2 Retruns 4
SELECT area_two.stusps10, area_two.name10
FROM tl_2010_us_state10 AS area_one, 
	tl_2010_us_state10 AS area_two 
WHERE ST_Touches(area_one.coords, area_two.coords) 
	AND area_one.name10 = 'North Carolina'
ORDER BY area_two.name10 ASC;

--Query 3 Returns 64
SELECT area_two.name10
FROM tl_2010_us_state10 AS area_one, 
	tl_2010_us_uac10 AS area_two 
WHERE ST_Contains(area_one.coords, area_two.coords)
	AND area_one.name10 = 'Colorado'
ORDER BY area_two.name10;

--Query 4 Returns 17
SELECT area_one.name10, ((area_one.aland10+area_one.awater10)/1000000) AS area 
FROM tl_2010_us_uac10 AS area_one,
	tl_2010_us_state10 AS area_two
WHERE ST_Overlaps(area_one.coords, area_two.coords)
	AND area_two.name10 = 'Pennsylvania'
ORDER BY area DESC;

--Query 5 Returns 84
SELECT area_one.name10, area_two.name10
FROM tl_2010_us_uac10 AS area_one,
	tl_2010_us_uac10 AS area_two
WHERE ST_Touches(area_one.coords, area_two.coords)
	AND (area_one.gid>area_two.gid);
	
--Query 6 Returns 10
SELECT area_one.name10, COUNT(*) AS stateCount 
FROM tl_2010_us_uac10 AS area_one, 
	tl_2010_us_state10 AS area_two 
WHERE ((area_one.aland10 + area_one.awater10)/1000000) > 1500 
	AND ST_Intersects(area_one.coords, area_two.coords) 
GROUP BY area_one.name10
HAVING COUNT(*) > 1
ORDER BY COUNT(*) DESC, area_one.name10 ASC;



