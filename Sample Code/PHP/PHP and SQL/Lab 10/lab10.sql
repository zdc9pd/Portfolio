DROP SCHEMA IF EXISTS lab10 CASCADE;
CREATE SCHEMA lab10;

SET SEARCH_PATH = lab10;

CREATE TABLE group_standings (
	team varchar(25) PRIMARY KEY,
	wins smallint NOT NULL CHECK(wins >=0),
	losses smallint NOT NULL CHECK(losses >= 0),
	draws smallint NOT NULL CHECK(draws >= 0),
	points smallint NOT NULL CHECK(points >= 0)
);

\copy group_standings FROM '/facstaff/klaricm/public_cs3380/lab10/lab10_data.csv' CSV HEADER

CREATE OR REPLACE FUNCTION calc_points_total(wins smallint, draws smallint)
RETURNS integer AS $$
	SELECT(3*($1)) + $2 AS result;
$$ LANGUAGE SQL;

CREATE OR REPLACE FUNCTION update_points_total() RETURNS TRIGGER AS $$
BEGIN
	NEW.pts := calc_points_total(NEW.wins, NEW.draws);
	NEW.pts := round(NEW.pts::numeric,4);
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER tr_update_points_total ON group_standings;
CREATE TRIGGER tr_update_points_total BEFORE INSERT OR UPDATE OF wins, draws  ON group_standings
FOR EACH ROW EXECUTE PROCEDURE update_points_total();

CREATE OR REPLACE FUNCTION disallow_team_name_update() RETURNS trigger AS $$
BEGIN
	IF (NEW.team <> OLD.team) THEN 
	RAISE EXCEPTION 'updating is not allowed'; 
	END IF;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER tr_disallow_team_name_update ON group_standings;
CREATE TRIGGER tr_disallow_team_name_update BEFORE UPDATE OF team ON group_standings
FOR EACH ROW EXECUTE PROCEDURE disallow_team_name_update();

