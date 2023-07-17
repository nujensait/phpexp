<?php

namespace Sessions;

/**
 * Postges DB connection
 */
final class PgConnection
{
    /**
     * Connection
     */
    private static ?PgConnection $conn = null;

    /**
     * Connect to DB
     * @return \PDO
     * @throws \Exception
     */
    public function connect()
    {
        // read .ini config file
        $params = parse_ini_file('database.ini');
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }

        // make DB connection
        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $params['host'],
            $params['port'],
            $params['database'],
            $params['user'],
            $params['password']
        );

        $pdo = new \PDO($conStr);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * тип @return
     */
    public static function get()
    {
        if (null === static::$conn) {
            static::$conn = new self();
        }

        return static::$conn;
    }
}