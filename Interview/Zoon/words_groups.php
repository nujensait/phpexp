<?php

/*
Необходимо написать функцию, которая принимает на вход массив со списком слов
и возвращает сгруппированные слова.
К одной группе относятся слова, которые могут быть получены одно из другого
с помощью произвольной перестановки букв.

Например:
    makeGroups( array('rfv', 'vfr', 'abc', 'bac', 'dbatre', 'qwer', 'cba', 'terbda') )

Вернет:
    array(
        array('rfv', 'vfr'),
        array('abc', 'bac', 'cba'),
        array('dbatre', 'terbda'),
        array('qwer'),
    )

Здесь rfv получается из vfr с помощью перестановки v и r, а из слов abc,
bac и cba формируется общая группа,
потому что любое из этих слов превращается в соседнее путём одной
или нескольких перестановок букв.

Протестируйте свой код.

(!) Это постановка задачи, решение см. в файле solution.php
*/

function makeGroups(array $words): array {
    return [
        ['rfv', 'vfr'],
        ['abc', 'bac', 'cba'],
        ['dbatre', 'terbda'],
        ['qwer'],
    ];
};
$r = makeGroups( array('rfv', 'vfr', 'abc', 'bac', 'dbatre', 'qwer', 'cba', 'terbda') );
print_r($r);
exit;