/*
Имеем следующие таблицы:

users — контрагенты
--------------
id - ИД контрагента
name - название контрагента
phone - телефон
email - почтовый вдрес
created — дата создания записи

orders — заказы
--------------
id
subtotal — сумма всех товарных позиций
created — дата и время поступления заказа (формат: "Y-m-d H:i:s")
city_id — город доставки
user_id — ИД контрагента


Необходимо выбрать одним запросом список контрагентов в следующем формате
(следует учесть, что будет включена опция only_full_group_by в MySql):

Имя контрагента
Его телефон
Сумма всех его заказов
Его средний чек
Дата последнего заказа


Решение:
*/

SELECT
    u.name,
    u.phone,
    SUM(o.subtotal) AS total_spend,
    AVG(o.subtotal) AS avg_check,
    MAX(o.created) AS last_order_date
FROM users u
         LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id
