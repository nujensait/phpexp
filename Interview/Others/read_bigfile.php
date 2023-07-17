<?php

// Напиши функцию на php, чтобы прочитать большой файл построчно ,
// Write a php function to read a large file line by line.

/**
 * Read file line by line
 * @param string $filename
 */
function readBigFile(string $filename)
{
    $file = fopen($filename, "r");

    while (!feof($file)) {
        yield fgets($file);
    }

    fclose($file);
}

// example of usage:

foreach (readBigFile("example.txt") as $line) {
    echo $line;
}

// output: contents of example.txt file line by line

