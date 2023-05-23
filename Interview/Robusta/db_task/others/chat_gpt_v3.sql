# Есть таблица Session:
# id, user_id, login_time, logout_time
# В ней хранится id пользователя, время входа и время выхода из системы
# (может быть null, если визит еще не завершен).
# Напиши sql запрос для заполнения таблицы Session случайными данными из 10 строк.

INSERT INTO Session (user_id, login_time, logout_time)
SELECT
        FLOOR(RAND() * 10) + 1,
        NOW() - INTERVAL FLOOR(RAND() * 10) DAY - INTERVAL FLOOR(RAND() * 23) HOUR - INTERVAL FLOOR(RAND() * 59) MINUTE - INTERVAL FLOOR(RAND() * 59) SECOND,
        IF(RAND() > 0.5, NOW() - INTERVAL FLOOR(RAND() * 10) DAY - INTERVAL FLOOR(RAND() * 23) HOUR - INTERVAL FLOOR(RAND() * 59) MINUTE - INTERVAL FLOOR(RAND() * 59) SECOND, NULL)
FROM
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS numbers;

# Есть таблица Session:
# id, user_id, login_time, logout_time
# В ней хранится id пользователя, время входа и время выхода из системы
# (может быть null, если визит еще не завершен).
# Напиши sql запрос, чтобы определить в какое время за отдельно взятые сутки
# в системе находилось одновременно максимальное число пользователей.
# error: Help: MySqlError { ERROR 1054 (42S22): Unknown column 's1.login_time' in 'where clause' }

SELECT
    COUNT(*) AS concurrent_users,
    login_time AS start_time,
    DATE_FORMAT(login_time, '%Y-%m-%d') AS date
FROM
    Session s1
WHERE
    (SELECT COUNT(*)
     FROM Session s2
     WHERE s2.login_time <= s1.login_time
       AND (s2.logout_time > s1.login_time OR s2.logout_time IS NULL)) =
    (SELECT MAX(concurrent_users)
     FROM (
            SELECT COUNT(*) AS concurrent_users
            FROM Session s3
            WHERE s3.login_time <= s1.login_time
              AND (s3.logout_time > s1.login_time OR s3.logout_time IS NULL)
            GROUP BY s3.login_time
        ) AS concurrent_users_by_time
    )
GROUP BY
    date, HOUR(login_time)
ORDER BY
    date, concurrent_users DESC
LIMIT 1;
