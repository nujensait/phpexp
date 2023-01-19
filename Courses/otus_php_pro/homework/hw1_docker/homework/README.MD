# Что это такое
Веб-сервер на основе Docker: запуск Nginx, PHP-FPM, MySQL, Memcached, Redis в контейнерах

# Источник задачи
Курс Otus PHP Pro: https://fas.st/wRyRs
Урок 1. Пример создания контейнера Docker

# Автор
Михаил Иконников <mishaikon@gmail.com>

# Источник
На основе первоисточников:
* https://github.com/ipanardian/docker-php-nginx-mysql-memcached
* https://developpaper.com/docker-quickly-builds-and-evolves-a-php-nginx-mysql-redis-xdebug-memcached-development-environment/

# Как запустить
docker build -t mishaikon/php71:latest -f DockerfilePhp71 .
docker-compose -f ./docker-compose.yml вверх

# Как остановить
докер-компоновать вниз

# Проверяем, что все работает
Открыть в браузере: http://localhost:8081/index.php