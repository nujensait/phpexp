# What is it?

My homework for lesson number 11
("How PostgreSQL works") at the course "Otus PHP Professional"

More about the course:
https://fas.st/wRyRs

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# Theme
Data indexing

# Target
Learn how to improve the performance of the database server at the level of settings administration.

# Exercise

## Description/Step-by-step instructions for completing homework
(!) In the database from the previous d/z (“Cinema theaters“):

Prepare a list of 6 basic queries to the database developed in the previous lessons.

It is advisable to choose:

* "simple" (1 table is involved),

* "complex" (aggregate functions, table links).

(!) Write a script/sql query to fill the main database tables with test data.

* Fill tables by increasing the total number of lines of text data to 10000.

* Analyze the performance of queries to the database, save execution plans.

* Populate the tables by increasing the total number of lines of text data to 10,000,000.

* Analyze the performance of queries to the database, save execution plans.

* Based on the analysis of requests and plans, propose optimizations (indexes, structure, parameters, etc.), execute them, compare the result (execution plans).



## Result
* database creation script (from previous lessons)
* script for filling the database with test data
* table with results for each of 6 queries
* inquiry
* DB plan:
    * up to 10000 lines
    * up to 10000000 lines
    * up to 10000000 lines
* what could be improved
* list of optimizations with explanations
* sorted list (15 values) of the largest database objects (tables, including indexes, indexes themselves)
* sorted lists (by 5 values) of the most frequently and rarely used indexes

## DECISION
We execute commands in the console, we look at the result:
(*) moved the analytics to a separate file - see otus_hw11_analytics.pdf
```
# run postgres client in console
pgsql

# 1. load old DB dump (see 'hw8_cinema_db')
\i 1_create_cinema_db.sql

# 2. load applied functions
\i 2_functions.sql

# 3. load data (small dump)
\i 3_fill_db_small.sql

# 4. exec analyze of simple queries
\i 4_simple_queries.sql

# 5. exec analyze of hard queries
\i 5_hard_queries.sql

# repeat steps 3-5 for other data dumps:
\i 3_fill_db_medium.sql
\i 4_simple_queries.sql
\i 5_hard_queries.sql

\i 3_fill_db_large.sql
\i 4_simple_queries.sql
\i 5_hard_queries.sql

# analyze outputs

# 6. get top large objects
\i 6_top_large_objects.sql

# 7. get mosy used indexes
\i 7_top_used_indexes.sql
```