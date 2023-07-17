<?php

namespace Sessions;

use Sessions\PgConnection as PgConnection;
use Sessions\SessionsDB as SessionsDB;

/**
 * Print sessions data
 */
class SessionsView
{
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = PgConnection::get()->connect();
            // echo "\n[ INFO ] Connection to the PostgreSQL database sever has been established successfully.\n";
        } catch (\PDOException $e) {
            echo "[ ERROR ] " . $e->getMessage() . "\n";
            die();
        }
    }

    public function printMaxSessionsOnDate(string $date): void
    {
        try {
            $dt = strtotime($date);
            if($dt === false) {
                throw new \Exception("[ ERROR ] Wrong date.");
            }
        } catch(\Exception $e) {
            print $e->getMessage() . "\n";
            return;
        }

        $dt1 = date("Y-m-d 00:00:00", $dt);
        $dt2 = date("Y-m-d 23:59:59", $dt);

        $this->printMaxSessionsOnPeriod($dt1, $dt2);
    }

    /**
     * Print statistics
     * @param string $date1
     * @param string $date2
     * @return void
     */
    public function printMaxSessionsOnPeriod(string $date1, string $date2): void
    {
        // Init DB data processing
        $sessionsDB = new SessionsDB($this->pdo);

        try {
            $dt1 = strtotime($date1);
            $dt2 = strtotime($date2);
            if($dt1 === false || $dt2 === false) {
                throw new \Exception("[ ERROR ] Wrong dates interval.");
            }
        } catch(\Exception $e) {
            print $e->getMessage() . "\n";
            return;
        }

        $maxSesionsData = $sessionsDB->getMaxSessionsTime($dt1, $dt2);

        if($maxSesionsData !== null && isset($maxSesionsData['count'])) {
            $periodStart = date("Y-m-d H:i:s", $maxSesionsData['period_start']);
            $periodEnd = date("Y-m-d H:i:s", $maxSesionsData['period_end']);

            print "[ RESULT ] Maximum amount of sessions on period [{$date1} ... {$date2}] \n" .
                "is on time interval [{$periodStart} ... {$periodEnd}]: {$maxSesionsData['count']}";
        } else {
            print "[ RESULT ] Data not found for period [{$date1} ... {$date2}]";
        }
    }

    /**
     * Output limited num of records from Sessioins table
     * @param int $limit
     * @param int $offset
     * @return void
     */
    public function printSessionsTable(int $limit = 1000, int $offset = 0): void
    {
        // Init DB data processing
        $sessionsDB = new SessionsDB($this->pdo);

        // read some sessions data
        $sessions = $sessionsDB->getSessions($limit, $offset);
        print("Sessions data: \n");
        print("===========================================\n");
        foreach($sessions as $row) {
            print(implode("\t|", $row)) . "\n";
        }
        print("===========================================\n");
    }
}