-- отсортированный список (15 значений) самых больших по размеру объектов БД
-- (таблицы, включая индексы, сами индексы)
select table_name as object, pg_relation_size(quote_ident(table_name)) as size
from information_schema.tables
where table_schema = 'public'
union all
select indexname as object, pg_indexes_size(quote_ident(tablename)) as size
from pg_indexes
order by size desc
    limit 15;