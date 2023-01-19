# Otus PHP Pro, Lesson 1.8 (#8), Basic Database Concepts - Homework
More about the course:
https://fas.st/wRyRs

## Target
Strengthen database design skills;
Learn how to properly normalize data storage;
To learn to describe a DB through DDL.

## Description of the task
Design Data Schema for Theater Control System

## Terms:
* the cinema has several halls,
* in each hall there are several different sessions,
  *customers can buy tickets for sessions

## Need to:
* Design a database for cinema management
* Document with a logical model
* Write DDL scripts
* Write SQL to find the most profitable movie

## Criteria for evaluation:
* Sufficiency of tables and links between them;
* Implementation of normalization rules;
* The presence of a logical model;
* Indication of data types in the logical model.

## Decision
* Data dumps of individual tables (we don't need them here):
  otus_hw8_public_hall.sql
* All files are merged into one (all here):
  cinema_db_postgres.sql
* Load this dump with commands:
```
pgsql
\i cinema_db_postgres.sql
```