//-- СЛОЖНЫЙ ЗАПРОС №1
//-- Фильмы с наибольшими сборами за последний месяц

select m.name as movie_name,
       count(o.id) as tickets_sold,
       sum(schedule.price) as revenue
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
where (o.paytime::date <= now()::date)
  and (o.paytime::date >= (now() - interval '30 day')::date)
group by movie_name
order by revenue desc;

-- movie_name        | tickets_sold | revenue
-- --------------------------+--------------+---------
--  idxY62vUhj3nTruujpUl6h   |           10 |    3582
--  bKqBHkZawSbnjAtJe1GuSGY  |           12 |    3531
--  vVaPaHlV1PAl             |           11 |    3449
--  jXsoyQX                  |           12 |    3331
--  SxwGPlk                  |            8 |    3021
--  2OVdns2VPjZ5Y            |            9 |    2817
--  ZVHX1bUjdgV5IHKr         |            9 |    2733
--  s2IHtx3PcSykH            |            5 |    1977
--  qdgh8Rnk                 |            5 |    1682
--  UphZUD4sfmkCZ            |            4 |    1638
--  RRAxWFQ                  |            6 |    1633
--  QNOcHKlcC                |            5 |    1606
--  6Xo8li6cOGD9hi3tvsKReN1  |            4 |    1260
--  UcULBDSSOQrC14Amw        |            3 |    1089
--  BTDnjq81kgi6Pyi          |            3 |    1038
--  HSnCeSH2cP               |            3 |     983
--  SudHyKnm2VWAhN           |            2 |     788
--  Y3UfEltRySq9OfwgE6TOa0HM |            2 |     590
--  baoyQZe7yzuG5h           |            2 |     267

-- анализируем запрос
explain analyse
select m.name as movie_name,
       count(o.id) as tickets_sold,
       sum(schedule.price) as revenue
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
where (o.paytime::date <= now()::date)
  and (o.paytime::date >= (now() - interval '30 day')::date)
group by movie_name
order by revenue desc;

-- Выборка без индекса i_order_paytime
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
--  Sort  (cost=17.19..17.19 rows=1 width=31) (actual time=0.598..0.601 rows=19 loops=1)
--    Sort Key: (sum(schedule.price)) DESC
--    Sort Method: quicksort  Memory: 26kB
--    ->  GroupAggregate  (cost=17.15..17.18 rows=1 width=31) (actual time=0.544..0.576 rows=19 loops=1)
--          Group Key: m.name
--          ->  Sort  (cost=17.15..17.16 rows=1 width=23) (actual time=0.530..0.537 rows=115 loops=1)
--                Sort Key: m.name
--                Sort Method: quicksort  Memory: 33kB
--                ->  Merge Right Join  (cost=11.32..17.14 rows=1 width=23) (actual time=0.299..0.333 rows=115 loops=1)
--                      Merge Cond: (m.id = schedule.movie_id)
--                      ->  Index Scan using movie_pk on movie m  (cost=0.41..2877.26 rows=9990 width=19) (actual time=0.017..0.022 rows=21 loops=1)
--                      ->  Sort  (cost=10.91..10.91 rows=1 width=12) (actual time=0.278..0.285 rows=115 loops=1)
--                            Sort Key: schedule.movie_id
--                            Sort Method: quicksort  Memory: 30kB
--                            ->  Hash Right Join  (cost=8.51..10.90 rows=1 width=12) (actual time=0.206..0.248 rows=115 loops=1)
--                                  Hash Cond: (schedule.id = o.schedule_id)
--                                  ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=12) (actual time=0.013..0.019 rows=100 loops=1)
--                                  ->  Hash  (cost=8.50..8.50 rows=1 width=8) (actual time=0.174..0.175 rows=115 loops=1)
--                                        Buckets: 1024  Batches: 1  Memory Usage: 13kB
--                                        ->  Seq Scan on "order" o  (cost=0.00..8.50 rows=1 width=8) (actual time=0.020..0.148 rows=115 loops=1)
--                                              Filter: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '30 days'::interval))::date))
--                                              Rows Removed by Filter: 85
--  Planning Time: 0.965 ms
--  Execution Time: 0.678 ms

// -- добавляем индекс
create index i_order_paytime on "order" (date(paytime));

-- Выборка с индексом i_order_paytime
-- QUERY PLAN
-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Sort  (cost=16.86..16.87 rows=1 width=31) (actual time=1.085..1.089 rows=19 loops=1)
--    Sort Key: (sum(schedule.price)) DESC
--    Sort Method: quicksort  Memory: 26kB
--    ->  GroupAggregate  (cost=16.83..16.85 rows=1 width=31) (actual time=1.010..1.074 rows=19 loops=1)
--          Group Key: m.name
--          ->  Sort  (cost=16.83..16.84 rows=1 width=23) (actual time=0.996..1.006 rows=115 loops=1)
--                Sort Key: m.name
--                Sort Method: quicksort  Memory: 33kB
--                ->  Merge Right Join  (cost=10.99..16.82 rows=1 width=23) (actual time=0.480..0.580 rows=115 loops=1)
--                      Merge Cond: (m.id = schedule.movie_id)
--                      ->  Index Scan using movie_pk on movie m  (cost=0.41..2877.26 rows=9990 width=19) (actual time=0.023..0.037 rows=21 loops=1)
--                      ->  Sort  (cost=10.58..10.59 rows=1 width=12) (actual time=0.448..0.469 rows=115 loops=1)
--                            Sort Key: schedule.movie_id
--                            Sort Method: quicksort  Memory: 30kB
--                            ->  Hash Right Join  (cost=8.19..10.57 rows=1 width=12) (actual time=0.216..0.343 rows=115 loops=1)
--                                  Hash Cond: (schedule.id = o.schedule_id)
--                                  ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=12) (actual time=0.027..0.042 rows=100 loops=1)
--                                  ->  Hash  (cost=8.18..8.18 rows=1 width=8) (actual time=0.164..0.164 rows=115 loops=1)
--                                        Buckets: 1024  Batches: 1  Memory Usage: 13kB
--                                        ->  Index Scan using order_date_idx on "order" o  (cost=0.16..8.18 rows=1 width=8) (actual time=0.027..0.113 rows=115 loops=1)
--                                              Index Cond: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '30 days'::interval))::date))
--  Planning Time: 0.893 ms
--  Execution Time: 1.249 ms

 -- Итого: выборка с индексом отработала дольше: 1.249 ms против 0.678 ms
 -- почему? - Загадка дыры ...

----------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- СЛОЖНЫЙ ЗАПРОС №1
-- Список юзеров, посмотревших фильмы из 10 букв

select u.name
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
         left join "user" as u on o."user_id" = u.id
where length(m."name") = 10;

-- анаилизируем выборку без индекса
explain analyze
select u.name
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
         left join "user" as u on o."user_id" = u.id
where length(m."name") = 10;

-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
--  Nested Loop Left Join  (cost=6.16..68.19 rows=1 width=17) (actual time=0.136..0.184 rows=6 loops=1)
--    ->  Nested Loop  (cost=5.88..65.26 rows=1 width=4) (actual time=0.123..0.151 rows=6 loops=1)
--          ->  Merge Join  (cost=5.73..64.78 rows=1 width=4) (actual time=0.111..0.129 rows=4 loops=1)
--                Merge Cond: (m.id = schedule.movie_id)
--                ->  Index Scan using movie_pk on movie m  (cost=0.41..2927.41 rows=50 width=4) (actual time=0.036..0.046 rows=2 loops=1)
--                      Filter: (length((name)::text) = 10)
--                      Rows Removed by Filter: 42
--                ->  Sort  (cost=5.32..5.57 rows=100 width=8) (actual time=0.064..0.069 rows=100 loops=1)
--                      Sort Key: schedule.movie_id
--                      Sort Method: quicksort  Memory: 29kB
--                      ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=8) (actual time=0.018..0.030 rows=100 loops=1)
--          ->  Index Scan using order_schedule_id_place_id_uindex on "order" o  (cost=0.14..0.46 rows=2 width=8) (actual time=0.004..0.004 rows=2 loops=4)
--                Index Cond: (schedule_id = schedule.id)
--    ->  Index Scan using user_pk on "user" u  (cost=0.29..2.92 rows=1 width=21) (actual time=0.005..0.005 rows=1 loops=6)
--          Index Cond: (id = o.user_id)
--  Planning Time: 1.308 ms
--  Execution Time: 0.239 ms

-- Создадим функциональный индекс: по длине имен фильмов
create index i_movie_name_length on "movie" using btree (length("name"));

-- выборка с индексом
-- QUERY PLAN
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
--  Nested Loop Left Join  (cost=6.16..68.19 rows=1 width=17) (actual time=0.146..0.212 rows=6 loops=1)
--    ->  Nested Loop  (cost=5.88..65.26 rows=1 width=4) (actual time=0.135..0.184 rows=6 loops=1)
--          ->  Merge Join  (cost=5.73..64.78 rows=1 width=4) (actual time=0.102..0.142 rows=4 loops=1)
--                Merge Cond: (m.id = schedule.movie_id)
--                ->  Index Scan using movie_pk on movie m  (cost=0.41..2927.41 rows=50 width=4) (actual time=0.032..0.056 rows=2 loops=1)
--                      Filter: (length((name)::text) = 10)
--                      Rows Removed by Filter: 42
--                ->  Sort  (cost=5.32..5.57 rows=100 width=8) (actual time=0.059..0.067 rows=100 loops=1)
--                      Sort Key: schedule.movie_id
--                      Sort Method: quicksort  Memory: 29kB
--                      ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=8) (actual time=0.017..0.029 rows=100 loops=1)
--          ->  Index Scan using order_schedule_id_place_id_uindex on "order" o  (cost=0.14..0.46 rows=2 width=8) (actual time=0.009..0.009 rows=2 loops=4)
--                Index Cond: (schedule_id = schedule.id)
--    ->  Index Scan using user_pk on "user" u  (cost=0.29..2.92 rows=1 width=21) (actual time=0.004..0.004 rows=1 loops=6)
--          Index Cond: (id = o.user_id)
--  Planning Time: 1.418 ms
--  Execution Time: 0.295 ms

 -- Итого: на малых объемах данных применение функционального индекса НЕ ускорило выборку

---------------------------------------------------------------------------------------------------------------------------------------------------------


