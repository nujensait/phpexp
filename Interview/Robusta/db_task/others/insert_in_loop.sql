# Insert random data into mysql in loop
# @source https://stackoverflow.com/questions/42516138/mysql-insert-multiple-rows-with-random-values
# test here: https://sqliteonline.com/

DROP PROCEDURE IF EXISTS proc_loop_test;
CREATE PROCEDURE proc_loop_test()
BEGIN
  DECLARE int_val INT DEFAULT 0;
  test_loop : LOOP
      IF (int_val = 10) THEN
      LEAVE test_loop;
END IF;
INSERT INTO `user_acc`(`playRegion`, `firsttimelogin`) VALUES
    (RAND() * (6)+1,1) ;
SET int_val = int_val +1;
END LOOP;
END;

drop table if exists `user_acc`;
create table `user_acc` (`playRegion` int, `firsttimelogin` int);

call proc_loop_test;

select * from `user_acc`;
