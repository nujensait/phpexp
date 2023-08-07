<?php

// Новый тип возврата - never

function redirect(string $url): never {
    header('Location: ' . $url);
    exit();
}

redirect('Test'); // код гарантирует не продолжение.

echo "We well not be here ...";

////////////////////

function foo(): never {
    $me = 123;
    return $me;         // Fatal error: A never-returning function must not return
}

foo();