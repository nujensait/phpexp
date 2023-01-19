# PHP_2022 Homework #10 (Lesson #12, ElasticSearch)

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# Well
Otus PHP Professional: https://fas.st/wRyRs

# Exercise
- we implement a search in an online bookstore using Elasticsearch
- each product has a name, category, price and number of stock left
- search should work correctly with typos and Russian morphology
- example: a user searches for all historical novels cheaper than 2000 rubles (and in stock) for the search query “knights”
- as a result, products ranked by relevance should be returned
- homework must be submitted as a PHP console application that accepts one or more command line parameters and
  displays the result in the form of a text tablet, after which it exits
- JSON with goods will be attached to the lesson in the personal account
- the way to create an index and its initial filling is up to you

# Installing the application
```
git clone https://github.com/otusteamedu/PHP_2022/
cd PHP_2022
git checkout Mikonnikov_hw12
cd code
composer install
composer update
```

# Application setup
Add to hosts Record like:
```
127.0.0.1 mysite.local
```

# Application launch
Run from project root
```
docker-compose build
docker-compose up -d
```

# Examination
Open URL in browser:
http://mysite.local

# Import data
Upload test data to Elasticsearch with the command:
```
curl -XPOST 'http://mysite.local:9200/_bulk' -H "Content-Type: application/json" --data-binary @books.json
```

# Search test
After starting the container, go to php-fpm and run a search:
```
docker exec -it php-fpm_hw10 bash
php /data/mysite.local/index/index.php "KnightOri"
```

Expected Result:
```
+----+--------------+---------------------- -------------------+--------------------+-------+- --------------------+
| # | SKU | Title | Category | Price | Availability |
+----+--------------+---------------------- -------------------+--------------------+-------+- --------------------+
| 1 | 500-000 | Who Framed Lieutenant Rzhevsky on the Moon | Historical romance | 3761 | Mira: 17, Lenin: 1 |
| 2 | 500-001 | Who framed the Terminator at home | Art | 8615 | Mira: 9, Lenin: 12 |
| 3 | 500-002 | Adventures of reptilians at night | Historical romance | 2065 | Mira: 16, Lenin: 16 |
| 4 | 500-003 | Tips for growing reptilians in Moscow | Detective | 2947 | Mira: 7, Lenin: 8 |
| 5 | 500-004 | What did the knights of Lieutenant Rzhevsky do in Moscow | Detective | 4620 | Mira: 1, Lenin: 6 |
| 6 | 500-005 | Tips for growing reptilians under the fly | Fantasy | 7538 | Mira: 13, Lenin: 10|
| 7 | 500-006 | Tips for growing reptilians under the bed | Art | 4247 | Mira: 8, Lenin: 20 |
| 8 | 500-007 | What did the knights of Lieutenant Rzhevsky do at night | Love story | 1572 | Mira: 5, Lenin: 2 |
| 9 | 500-008 | Terrible crimes of reptilians abroad | Fantasy | 4807 | Mira: 6, Lenin: 0 |
| 10 | 500-009 | Who framed Stirlitz at home | Detective | 9447 | Mira: 15, Lenin: 10|
+----+--------------+---------------------- -------------------+--------------------+-------+- --------------------+
```