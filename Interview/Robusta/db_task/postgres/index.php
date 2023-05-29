<?php

/**
 * Robusta test task #2: find max sessions period
 */

require 'vendor/autoload.php';

use Sessions\SessionsView as SessionsView;

$stat = new SessionsView();
// $stat->printSessionsTable(5, 0);
// $stat->printMaxSessionsOnPeriod('2023-01-01 00:00:00', '2023-06-01 23:59:59');       // Ищем интервал с максимумом сессий за все время: 350
$stat->printMaxSessionsOnDate('2023-05-23');      // за конкретную дату: 233


