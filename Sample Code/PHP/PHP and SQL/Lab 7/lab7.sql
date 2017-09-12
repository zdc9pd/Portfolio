-- Zac Crane
-- 14151501

--Query 1
	--The query plan shows an index, because no index has been created and the query plan utilizes the PK since it is unique
	--The index comes from the Primary Key for the table, which was also used as the WHERE clause

--Query 2
	SELECT * FROM banks WHERE state = 'Missouri';
	EXPLAIN ANALYZE SELECT * FROM banks WHERE state = 'Missouri';
		--  QUERY PLAN
		--------------------------------------------------------------------------
		-- Seq Scan on banks  (cost=0.00..894.98 rows=996 width=124) (actual time=0.447..18
		--.352 rows=996 loops=1)
		--   Filter: ((state)::text = 'Missouri'::text)
		-- Total runtime: 19.387 ms
		--(3 rows)

	CREATE INDEX ON lab7.banks(state);
	EXPLAIN ANALYZE SELECT * FROM banks WHERE state = 'Missouri';
		--QUERY PLAN
		---------------------------------------------------------------------------------
		-- Bitmap Heap Scan on banks  (cost=23.97..598.42 rows=996 width=124) (actual time=
		--0.269..2.635 rows=996 loops=1)
		--   Recheck Cond: ((state)::text = 'Missouri'::text)
		--   ->  Bitmap Index Scan on banks_state_idx  (cost=0.00..23.72 rows=996 width=0)
		--(actual time=0.218..0.218 rows=996 loops=1)
		--         Index Cond: ((state)::text = 'Missouri'::text)
		-- Total runtime: 3.219 ms
		--(5 rows)

	--5. unindex: 19.387ms
	--	 index:    3.219ms
	-- 		Speed up = 19.378ms - 3.219ms = 16.159ms faster
	--		Percentage: (19.378ms / 3.219ms ) * 100 = 601.99% faster
	--			or : (3.219ms / 19.378ms) * 100 = 16.61% of the time it took for the unindexed
	

 
--Query 3
	SELECT * FROM banks ORDER BY name asc;
	EXPLAIN ANALYZE SELECT * FROM banks ORDER BY name asc;
		--QUERY PLAN
		---------------
		--Sort  (cost=4657.15..4726.14 rows=27598 width=124) (actual time=299.473..440.342
		-- rows=27598 loops=1)
		--  Sort Key: name
		--   Sort Method: external merge  Disk: 3760kB
		-- ->  Seq Scan on banks  (cost=0.00..825.98 rows=27598 width=124) (actual time=0
		--.026..31.988 rows=27598 loops=1)
		-- Total runtime: 465.972 ms
		--(5 rows)
	CREATE INDEX ON lab7.banks(name);
	EXPLAIN ANALYZE SELECT * FROM banks ORDER BY name asc;
		--QUERY PLAN
		---------------
		--Index Scan using banks_name_idx on banks  (cost=0.00..3294.27 rows=27598 width=124) (actual time=0.091..59.383 rows=27598 loops=1)
		--Total runtime: 84.433 ms
		--(2 rows)
	--5. unindex: 466ms
	--	index: 84ms
	--		speed up = 466ms - 84ms = 382ms faster
	--		percentage: (466ms / 84ms) * 100 = 555% faster
	--		or:  (84ms/466ms) *100 = 18% of the time it took for unindex


--Query 4 
	CREATE INDEX ON lab7.banks(is_active);
--Query 5
	-- Of the two queries, the "is_active = TRUE" uses an index and the "is_active = FALSE" does not use an index.
	EXPLAIN ANALYZE SELECT * FROM BANKS WHERE is_active=true;
		--QUERY PLAN
		---------------
		--Bitmap Heap Scan on banks  (cost=132.77..750.53 rows=6776 width=124) (actual time=1.326..12.058 rows=6776 loops=1)
		--  Filter: is_active
		--   ->  Bitmap Index Scan on banks_is_active_idx  (cost=0.00..131.07 rows=6776 width=0) (actual time=1.199..1.199 rows=6776 loops=1)
		--       Index Cond: (is_active = true)
		-- Total runtime: 17.560 ms
		--(5 rows)

		
	EXPLAIN ANALYZE SELECT * FROM BANKS WHERE is_active=false;
		--QUERY PLAN
		-------------------
		-- Seq Scan on banks  (cost=0.00..825.98 rows=20822 width=124) (actual time=0.013..23.152 rows=20822 loops=1)
		--Filter: (NOT is_active)
		--Total runtime: 40.573 ms
		--(3 rows)
		
	--Looking at these two explain statements, it is clear that the "true" one is using an index.
		--The true explain has an index listed and uses a bitmap heap scan
		--The false explain has a filter and does a seq. scan
	-- The index is not used on the false values becuase when the index is created on the boolean, the 
		-- true values are automatically indexed and the false are not (as a way to be able to separate the two)
--Query 6
	SELECT * FROM banks WHERE insured >= '2000-01-01';
	EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01';
		-- QUERY PLAN
		-------------
		--Seq Scan on banks  (cost=0.00..894.98 rows=1450 width=124) (actual time=2.599..10.624 rows=1451 loops=1)
		--Filter: (insured >= '2000-01-01'::date)
		--Total runtime: 11.844 ms
		--(3 rows)
	CREATE INDEX ON lab7.banks(insured) WHERE NOT (insured = '1934-01-01');
	SELECT * FROM banks WHERE insured >= '2000-01-01';
	EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01';
		--QUERY PLAN
		--------------
		--Index Scan using banks_insured_idx on banks  (cost=0.00..573.89 rows=1450 width=124) (actual time=0.048..2.188 rows=1451 loops=1)
		--  Index Cond: (insured >= '2000-01-01'::date)
		-- Total runtime: 3.405 ms
		--(3 rows)
	--Speed up: unindex: 11.8ms
	--			index: 3.4ms
	--			speed up = 11.8ms - 3.4ms = 8.4ms faster
	-- Perfectage:
	--	(3.4/11.8)*100 = 28.8% of the time
	--	(11.8/3.4)*100 = 347.1% faster
	
--Query 7

SELECT id,name,city, state, assets, deposits FROM banks WHERE (assets/deposits) < .5 AND deposits != 0;
EXPLAIN ANALYZE SELECT id,name,city, state, assets, deposits FROM banks WHERE (assets/deposits) < .5 AND deposits != 0;
	--QUERY PLAN
	----------------
	--Seq Scan on banks  (cost=0.00..1032.97 rows=9166 width=63) (actual time=35.779..47.056 rows=46 loops=1)
	--Filter: ((deposits <> 0::numeric) AND ((assets / deposits) < 0.5))
	--Total runtime: 47.139 ms
	--(3 rows)
CREATE INDEX ON lab7.banks((assets/deposits)) WHERE NOT (deposits = 0);
SELECT id,name,city, state, assets, deposits FROM banks WHERE (assets/deposits) < .5 AND deposits != 0;
EXPLAIN ANALYZE SELECT id,name,city, state, assets, deposits FROM banks WHERE (assets/deposits) < .5 AND deposits != 0;
	--QUERY PLAN
	----------------
	--Bitmap Heap Scan on banks  (cost=215.54..925.95 rows=9166 width=63) (actual time=0.046..0.175 rows=46 loops=1)
	--Recheck Cond: (((assets / deposits) < 0.5) AND (deposits <> 0::numeric))
	-- ->  Bitmap Index Scan on banks_expr_idx  (cost=0.00..213.25 rows=9166 width=0)
	--(actual time=0.029..0.029 rows=46 loops=1)
	--      Index Cond: ((assets / deposits) < 0.5)
	--Total runtime: 0.256 ms
	--(5 rows)
--SPEED UP: unindex: 47.1ms
--			index: .256ms
--			speed up = 47.1ms -.256ms = 46.844 ms faster
--PERCENTAGE:
--	(.256/47.1)*100 = .54% of the time
--	(47.1/.256)*100 = 18398% faster


