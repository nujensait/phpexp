<?php

/**
 * Calc string hah
 * @param string $word
 * @return string
 */
function calcHash(string $word): string
{
    $hash = '';

    $cnt = [];
    for($i = 0; $i < mb_strlen($word); $i++) {
        $chr = mb_substr($word, $i, 1);
        if(isset($cnt[$chr])) {
            $cnt[$chr]++;
        } else {
            $cnt[$chr] = 1;
        }
    }

    ksort($cnt);

    $hash = md5(json_encode($cnt));

    return $hash;
}

/**
 * Make words groups
 * @param array $words
 * @return array
 */
function makeGroups(array $words): array
{
    $ret = [];

    foreach($words as $word) {
        $hash = calcHash($word);
        //echo "Hash for $word: $hash\n";
        $ret[$hash][] = $word;
    }

    return array_values($ret);
};

$r = makeGroups( array('rfv', 'vfr', 'abc', 'bac', 'dbatre', 'qwer', 'cba', 'terbda') );
print_r($r);
exit;