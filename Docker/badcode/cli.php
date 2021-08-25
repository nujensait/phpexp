<?php

// @see https://badcode.ru/docker-tutorial-dlia-novichkov-rassmatrivaiem-docker-tak-iesli-by-on-byl-ighrovoi-pristavkoi/

$n = $i = $argv[1] ?? 5; //а было $n = $i = 5
// это значит, что мы принимаем аргумент из консоли, а если он не получен, то используем по-умолчанию 5

while ($i--) {
    echo str_repeat(' ', $i).str_repeat('* ', $n - $i)."\n";
}