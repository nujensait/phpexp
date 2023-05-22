# Есть таблица Session:
# id, user_id, login_time, logout_time
# В ней хранится id пользователя, время входа и время выхода из системы
# (может быть null, если визит еще не завершен).
# Напиши sql запрос, чтобы определить в какое время за отдельно взятые сутки
# в системе находилось одновременно максимальное число пользователей.

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
