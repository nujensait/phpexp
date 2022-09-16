// ---------------------------------------------------------------------------------------------------
// -- ПРОСТОЙ ЗАПРОС №1
// -- Фильмы, длящиеся больше 90 минут
explain analyse
select "name" 
from "movie" 
where duration >= 90;

//      QUERY PLAN
// ---------------------------------------------------------------------------------------------------
//     Seq Scan on movie  (cost=0.00..11.75 rows=47 width=32) (actual time=0.035..0.039 rows=14 loops=1)
// Filter: (duration >= 90)
// Rows Removed by Filter: 6
// Planning Time: 343.607 ms
// Execution Time: 920.325 ms

// ---------------------------------------------------------------------------------------------------
// -- Добавляем еще на порядок больше данных: 10.000 записей
insert into movie(id, name, duration)
select gs.id,
       random_string((5 + random() * 20)::integer),
       random_integer(60, 180) 
from generate_series(21, 10000) as gs(id);

// -- Выборка без индекса
explain analyse 
select "name" 
from "movie" 
where duration >= 90;
//                                                QUERY PLAN
// --------------------------------------------------------------------------------------------------------
//     Seq Scan on movie
// (cost=0.00..193.00 rows=7637 width=32)
// (actual time=0.020..1.683 rows=7557 loops=1)
// Filter: (duration >= 90)
// Rows Removed by Filter: 2443
// Planning Time: 0.998 ms
// Execution Time: 1.954 ms

// -- Добавляем индекс
create index movie_duration_index on movie (duration);

// -- То же самое с индексом
// QUERY PLAN
// ------------------------------------------------------------------------------------------------------------------------------------------
//     Index Only Scan using movie_duration_index on movie
// (cost=0.29..169.93 rows=7637 width=32)
// (actual time=5.091..6.072 rows=7557 loops=1)
// Index Cond: (duration >= 90)
// Heap Fetches: 0
// Planning Time: 6.946 ms
// Execution Time: 6.340 ms

// -- Итого, время выборки данных с индексом замедлилось в 3.2 раз (6.340 / 1.954)
// -- интересно, почему так? должно было уменьшиться ...
// -- но т.к. этот текст не прочитают, это останется тайной )

// ------------------------------------------------------------------------------------------------------------------------------------------
// -- повторим эскперимент на бОльшем объеме данных: 1.000.000 строк
insert into movie(id, name, duration)
select gs.id,
       random_string((5 + random() * 20)::integer),
       random_integer(60, 180) 
from generate_series(10001, 1000000) as gs(id);

// -- ...
//
// ------------------------------------------------------------------------------------------------------------------------------------------
//     -- ПРОСТОЙ ЗАПРОС №2
// -- Билеты, купленные за последние 7 дней
// -- эксперимент на 200 записях
explain analyse 
select * 
from "order" 
where (paytime::date <= now()::date)   
and (paytime::date >= (now() - interval '7 day')::date);
//                                                   QUERY PLAN
// --------------------------------------------------------------------------------------------------------------
//     Seq Scan on "order"  (cost=0.00..8.50 rows=1 width=24)
// (actual time=0.032..0.149 rows=31 loops=1)
// Filter: (((paytime)::date <= (now())::date)
// AND ((paytime)::date >= ((now() - '7 days'::interval))::date))
// Rows Removed by Filter: 169
// Planning Time: 4.137 ms
// Execution Time: 0.170 ms

// -- добавляем индекс
create index on "order" (date(paytime));

// -- выборка с индексом
explain analyse 
select * 
from "order" 
where (paytime::date <= now()::date)   
and (paytime::date >= (now() - interval '7 day')::date);
//                                                         QUERY PLAN
// --------------------------------------------------------------------------------------------------------------------------
//     Index Scan using order_date_idx on "order"
// (cost=0.16..8.18 rows=1 width=24)
// (actual time=0.037..0.049 rows=31 loops=1)
// Index Cond: (((paytime)::date <= (now())::date)
// AND ((paytime)::date >= ((now() - '7 days'::interval))::date))
// Planning Time: 1.067 ms
// Execution Time: 0.080 ms

// -- с индексом сработало быстрее в 2 раза судя по Execution Time: 0.170 / 0.080
//
// -- добавим записей в заказы
INSERT INTO public."order"
(id, user_id, schedule_id, paytime, place_id)
select gs.id,
       random_integer(1, 10000),
       random_integer(1, 100),
       random_timestamp(),
       random_integer(1, 600) 
from generate_series(201, 100000) as gs(id);

// -- ...
//
// --------------------------------------------------------------------------------------------------------------------------
// -- ПРОСТОЙ ЗАПРОС №3
// -- Выборка юзеров по длине имени

explain analyze
select count(*) 
from "user" 
where length("name") = 10;

//                                                QUERY PLAN
// -----------------------------------------------------------------------------------------------------------
//     Aggregate  (cost=251.13..251.13 rows=1 width=8)
// (actual time=2.837..2.838 rows=1 loops=1)
// ->  Seq Scan on "user"  (cost=0.00..251.00 rows=50 width=0)
// (actual time=0.023..2.793 rows=533 loops=1)
// Filter: (length((name)::text) = 10)
// Rows Removed by Filter: 9467
// Planning Time: 0.346 ms
// Execution Time: 2.873 ms

// -- у нас 10.000 записей
select count(*) from "user";
//  count
// -------
//     10000
//
// -- Создадим функциональный индекс: по длине имен юзеров
create index i_user_name_length on "user" using btree (length("name"));

// -- та же выборка с индексом
explain analyze 
select count(*) 
from "user" 
where length("name") = 10;
//                                                              QUERY PLAN
// ------------------------------------------------------------------------------------------------------------------------------------
//     Aggregate  (cost=91.18..91.19 rows=1 width=8)
// (actual time=0.429..0.430 rows=1 loops=1)
// ->  Bitmap Heap Scan on "user"
// (cost=4.67..91.05 rows=50 width=0)
// (actual time=0.325..0.394 rows=533 loops=1)
// Recheck Cond: (length((name)::text) = 10)
// Heap Blocks: exact=101
// ->  Bitmap Index Scan on i_user_name_length
// (cost=0.00..4.66 rows=50 width=0)
// (actual time=0.126..0.126 rows=533 loops=1)
// Index Cond: (length((name)::text) = 10)
// Planning Time: 0.197 ms
// Execution Time: 0.577 ms
//
// -- Итого: запрос с индексом отработал быстрее в 5 раз (Execution Time: 2.873 / 0.577) 
 