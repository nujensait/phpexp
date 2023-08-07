<?php

// Fsynk

$file = fopen("sample.txt", "w");
fwrite($file, "Some content");

if (fsync($file)) {
    print("File save OK");
}

fclose($file);
