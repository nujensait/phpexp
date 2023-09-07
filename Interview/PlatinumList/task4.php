<?php

/**
 * Parse ini file with subsections
 * @param string $filename
 * @return array
 */
function parse(string $filename): array
{
    $res = parse_ini_file($filename, true);

    if(is_array($res) && count($res)) {
        foreach($res as $k => &$data) {
            if(strstr($k, '/') !== false) {
                $subNames = explode('/', $k);
                // make subsections inside current section
                $subsec = &$res;
                foreach($subNames as $subName) {
                    $subsec = &$subsec[$subName];
                }
                $subsec = $data;
                // delete original section with composite key
                unset($res[$k]);
            }
        }
    }

    return $res;
}

$data = parse('config.ini');
print_r($data);