<?php

/**
 * Robusta test task #2: find max sessions period
 */

require 'vendor/autoload.php';

use Sessions\PgConnection as PgConnection;
use Sessions\SessionsDB as SessionsDB;

try {
    $pdo = PgConnection::get()->connect();
    echo "\n[ INFO ] Connection to the PostgreSQL database sever has been established successfully.\n";
} catch (\PDOException $e) {
    echo "[ ERROR ] " . $e->getMessage() . "\n";
}

// Init DB data processing
$sessionsDB = new SessionsDB($pdo);

// read some sessions data
$sessions = $sessionsDB->getSessions(0, 5);
print("Sessions data: \n");
print("=====================================\n");
foreach($sessions as $row) {
    print(implode("\t|", $row));
}
print("=====================================\n");

// calc required stat
//$datetime = new DateTime();
//$datetime->setDate(2023, 5, 22);
//$maxSesions = getMaxSessionsTimeOnDate($datetime);
//var_dump($maxSesions);
