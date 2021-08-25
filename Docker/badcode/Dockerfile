FROM php:7.2-cli
COPY cli.php /cli.php
RUN chmod +x /cli.php
ENTRYPOINT ["php", "/cli.php"]
## аргумент, который передаётся в командную строку
CMD  ["9"]
