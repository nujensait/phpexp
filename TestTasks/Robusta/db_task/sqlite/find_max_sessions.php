<?php

/**
 * Есть таблица Session:
 *   ```
 *   id, user_id, login_time, logout_time
 *   ```
 *   В ней хранится id пользователя, время входа и время выхода из системы
 *   (может быть null, если визит еще не завершен).
 *
 *   Определить в какое время за отдельно взятые сутки в системе находилось одновременно
 *   максимальное число пользователей.
 */

/**
 * Database
 * @param $date
 * @return mixed|null
 */
class DB extends SQLite3
{
    /**
     * @param string $file
     */
    function __construct( string $file )
    {
        $this->open( $file );
    }
}

/**
 * Sessions
 */
class Sessions
{
    private $db;

    /**
     * @param string $file
     */
    function __construct(string $file)
    {
        $db = new DB($file);
    }

    /**
     * @param DateTime $date
     * @return mixed|null
     */
    function getMaxUsersActivityTime(\DateTime $date)
    {
        $query = 'SELECT * FROM `sessions` WHERE DATE(`login_time`) = :date ORDER BY login_time ASC';
        $users = $this->db->query($query, [':date' =>  $date->format('Y-m-d')]);

        $times = [];
        $result = [];
        $i = 0;

        foreach ($users as $key => $user) {
            $login_time = \DateTime::createFromFormat('Y-m-d H:i:s', $user['login_time']);
            $logout_time = \DateTime::createFromFormat('Y-m-d H:i:s', $user['logout_time']);

            $times[$key] = [
                'login' => $login_time->getTimestamp(),
                'logout' => $logout_time->getTimestamp()
            ];

            if (isset($times[$key - 1])) {
                $prev = $times[$key - 1];
                if ($prev['logout'] < $times[$key]['login'] && 0 < $prev['logout']) {
                    $i++;
                }
                if (($prev['login'] <= $times[$key]['logout'] && $prev['logout'] >= $times[$key]['login']) ||
                    (0 > $prev['logout'] && $prev['login'] <= $times[$key]['login']) ||
                    (0 > $times[$key]['logout'] && $prev['logout'] >= $times[$key]['login'])) {

                    $result[$i][] = $users[$key - 1];
                    $result[$i][] = $user;
                }
            }
        }

        /**
         * @param $items
         * @param $key
         * @return array
         */
        function pluck($items, $key)
        {
            return array_map(function ($item) use ($key) {
                return \is_object($item) ? $item->$key : $item[$key];
            }, $items);
        }

        $result = \array_map(function ($items) {
            $items = \array_unique($items, \SORT_REGULAR);
            $items += [
                'count' => \count($items),
                'period' => \min(pluck($items, 'login_time')) . '/' . \max(pluck($items, 'logout_time'))
            ];
            return $items;
        }, $result);

        \usort($result, function ($a, $b) {
            return ($a['count'] < $b['count']);
        });

        return \array_shift($result);
    }
}

$sessions = new Sessions('sessionsDB.sqlite');

$datetime = new DateTime();
$datetime->setDate(2020, 5, 1);
$datetime->setTime(0, 0, 0);

$maxSessions = $sessions->getMaxUsersActivityTime();

var_dump($maxSessions);