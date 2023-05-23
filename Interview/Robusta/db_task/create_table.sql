# Создаем таблицу под задачу

DROP TABLE IF EXISTS `Session`;

CREATE TABLE `Session` (
   `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
   `user_id` INT(11) NOT NULL COMMENT 'User ID',
   `login_time` DATETIME NOT NULL COMMENT 'Login time',
   `logout_time` DATETIME COMMENT 'Logout time',
   PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

# Вставка данных через процедуру

DROP PROCEDURE IF EXISTS insert_sessions_random_data;
CREATE PROCEDURE insert_sessions_random_data()
BEGIN
    DECLARE int_val INT DEFAULT 0;
    insert_loop : LOOP
        IF (int_val = 100) THEN
            LEAVE insert_loop;
        END IF;
            INSERT INTO Session (user_id, login_time, logout_time)
            VALUES(
                FLOOR(RAND() * 100) + 1,
                NOW() - INTERVAL FLOOR(RAND() * 10) DAY - INTERVAL FLOOR(RAND() * 23) HOUR - INTERVAL FLOOR(RAND() * 59) MINUTE - INTERVAL FLOOR(RAND() * 59) SECOND,
                IF(RAND() > 0.5, NOW() - INTERVAL FLOOR(RAND() * 10) DAY - INTERVAL FLOOR(RAND() * 23) HOUR - INTERVAL FLOOR(RAND() * 59) MINUTE - INTERVAL FLOOR(RAND() * 59) SECOND, NULL));
        SET int_val = int_val +1;
    END LOOP;
END;

CALL insert_sessions_random_data;

# Проверяем что у нас вставилось
select * from Session;

