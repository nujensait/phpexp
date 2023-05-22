## Задача №1

Напишите функцию на PHP, которая принимает на вход матрицу вещественных чисел 
(единственный параметр) и возвращает её ранг. 

(!) Пожалуйста не используйте библиотечные классы и методы для работы с матрицами.

А также не используйте цикл "for" (foreach и все остальное - можно).

#### Мое примечание: 
- Попросим нейронку ChatGPT написать нам базовое решение, и доработаем его уже как следует.
- См. историю правок файла matrix_rank.php

#### Материалы по теме
- Алгоритм и пример нахождения ранга матрицы на js: https://matrix.reshish.ru/rankCalculation.php 
- Решения на разных языках: https://www.geeksforgeeks.org/program-for-rank-of-matrix/ (берем его за алг. основу и доработаем под себя) 

#### Наработки по теме

В папке others:
- others/matrix_rank_geeks.php - решение с сайта geeksforgeeks.org (для диагональных матриц)
- others/matrix_rank_gpt3.php  - решение, сгенерированное нейронной сетью ChatGPT v.3.0 (некорректное)
- others/matrix_rank_gpt4.php  - решение, сгенерированное нейронной сетью ChatGPT v.4.5 (некорректное)

В корневой папке:
- MatrixRankOperation.php      - мое решение рабочее: комбо двух первых решений выше

#### Пояснение к финальному решению

См. тут: https://www.geeksforgeeks.org/program-for-rank-of-matrix/

#### Запуск
```
php MatrixRankOperation.php
Ранг матрицы: 2

# run tests
phpunit MatrixRankOperationTest.php
```