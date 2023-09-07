<?php

/**
 * INI file parser
 * (*) code generated by Claude AI (ChatGPT analog)
 * NON-working version
 */

function parse_ini(string $filename): array
{
    $data = [];
    $section = null;

    $lines = file($filename);
    foreach ($lines as $line) {

        $line = trim($line);

        if (strlen($line) === 0) {
            continue;
        }

        if ($line[0] === ';') {
            // Комментарий
            continue;
        }

        if ($line[0] === '[' && $line[-1] === ']') {
            // Новая секция
            $section = substr($line, 1, -1);
            $data[$section] = [];
            continue;
        }

        // Разделитель ключ/значение
        $parts = explode('=', $line, 2);
        $key = trim($parts[0]);
        $value = trim($parts[1]);

        // Подсекция
        if (strpos($key, '/') !== false) {
            $path = explode('/', $key);
            $subsec = &$data;
            foreach ($path as $k) {
                $subsec = &$subsec[$k];
            }
            $subsec = $value;
        } else {
            // Обычный ключ
            $data[$section][$key] = $value;
        }
    }

    return $data;
}

$data = parse_ini('config.ini');
print_r($data);