# Что это такое
Примеры ограничения использования памяти, написанные на PHP

# Источник задачи
Курс Otus PHP Pro: https://fas.st/wRyRs
Урок 3: Внутренняя структура PHP

# Описание задания
Чтение данных из БОЛЬШОГО файла import.csv
Получить данные 1-го столбца отсюда
Вывести все данные из этого столбца в result.csv
(*) у нас есть ограничение по памяти: разрешено только 1Mb для выполнения скрипта

# Автор
Михаил Иконников <mishaikon@gmail.com>

# Как запустить

## Создать CSV-файл
php run.php

## Запустить скрипт с плохим использованием памяти
php memory_limit_error.php

## Запустить скрипт с использованием памяти для еды
php memory_limit_ok.php

## Пример использования
> php run.php
[ START CREATING CSV ... ]
[ File with 100000 lines created ]
[ DONE ]

> php memory_limit_error.php
[ Current memory limit: 128M ]
[ Set new memory limit ... ]
[ New memory limit: 1M ]
[ START IMPORT ... ]
PHP Fatal error:  Allowed memory size of 2097152 bytes exhausted (tried to allocate 3301488 bytes) in E:\OpenServer
\OSPanel\domains\codexamps\src\mishaikon\phpexp\Courses\otus_php_pro\lesson3_phpint\memory_limit_error.php on line
27

> php memory_limit_ok.php
[ Current memory limit: 128M ]
[ Set new memory limit ... ]
[ New memory limit: 1M ]
[ START IMPORT ... ]
[ Lines written: 100000 ]
[ DONE ]
