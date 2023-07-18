/*
Напиши SQL-запросы

Имеем следующую MySQL таблицу со списком сотрудников:

employees
----------------------------------------------
Id  Name    LastName    DepartamentId   Salary
1   Иван    Смирнов     2               100000
2   Максим  Петров      2               90000
3   Роман   Иванов      3               95000
*/

/* Напиши sql-запрос для вывода самой большой зарплаты в каждом департаменте */
SELECT
    DepartamentId,
    MAX(Salary) AS MaxSalary
FROM employees
GROUP BY DepartamentId

/* Напиши sql-запрос для вывода списка сотрудников из 3-го департамента, у которых ЗП больше 90000 */

SELECT *
FROM employees
WHERE DepartamentId = 3
  AND Salary > 90000

/* Напиши sql-запрос по созданию индексов для ускорения выборки данных */

-- Индекс для фильтрации по DepartamentId
CREATE INDEX idx_employees_departament
    ON employees(DepartamentId);

-- Индекс для сортировки и фильтрации по зарплате
CREATE INDEX idx_employees_salary
    ON employees(Salary);

-- Составной индекс для фильтрации по двум столбцам
CREATE INDEX idx_employees_departament_salary
    ON employees(DepartamentId, Salary);

