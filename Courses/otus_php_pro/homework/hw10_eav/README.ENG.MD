# What is it?

My homework for lesson #10 ("PostgreSQL for Developers") in the course "Otus PHP Professional"
https://fas.st/wRyRs

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# Exercise
Design EAV storage for cinema database 4 tables:
- movies,
- attributes,
- attribute types,
- attribute values.

## Attribute types and their corresponding attributes (for example):
- reviews (text values) - reviews from critics, review from an unknown film academy...
- award (replaced when printing banners and tickets for an image, boolean value) - oscar, nick ...
- important dates (when printing - attribute name and date value, date type) - world premiere, premiere in Russia ...
- business dates (used in planning, date type) - start date of ticket sales, when to start advertising on TV ...

## View assembly service data in the form (three columns):
- movie
- tasks relevant for today,
- tasks relevant in 20 days

## View data assembly for marketing in the form (three columns):
- movie,
- attribute type,
- attribute,
- value (value is displayed as text)

## Criteria for evaluation:
- All valid data types are taken into account
- The specifics of storage and subsequent use of float data are taken into account
- EAV-scheme is equipped with indexes

## DECISION
We execute commands in the console, we look at the result:
```
# run postgres client in console
pgsql

# load old dump (see 'hw8_cinema_db')
\i cinema_db_postgres.sql

# load current changes in file
\i eav_cinema_db.sql
```