<?php

namespace Sessions;

/**
 * PostgreSQL PHP Update Demo
 */
class SessionsDB
{
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @param int|null $limit
     * @param int|null $from
     * @return array
     */
    public function getSessions(int $limit = null, int $from = null) : array
    {
        $limitStmt = "";
        if($limit !== null) {
            $limitStmt .= " LIMIT " . intval($limit) . " ";
        }
        if($from !== null) {
            $limitStmt .= " OFFSET " . intval($limit) . " ";
        }

        $stmt = $this->pdo->query(
            'SELECT id, user_id, login_time, logout_time '
            . 'FROM timetable '
            . 'ORDER BY id ASC ' .
            $limitStmt);

        $sessions = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $sessions[] = $row;
        }

        return $sessions;
    }

    /**
     * @param DateTime $date
     * @return mixed|null
     */
    function getMaxSessionsTimeOnDate(\DateTime $date)
    {
        $query = 'SELECT * 
                  FROM public.timetable 
                  WHERE DATE(`login_time`) = :date 
                  ORDER BY login_time ASC';

        $stmt = $this->pdo->query($query, [':date' =>  $date->format('Y-m-d')]);

        $times = [];
        $result = [];
        $i = 0;

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach($rows as $key => $row) {
            $login_time  = \DateTime::createFromFormat('Y-m-d H:i:s', $row['login_time']);
            $logout_time = \DateTime::createFromFormat('Y-m-d H:i:s', $row['logout_time']);

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
                    // swap results
                    $result[$i][] = $rows[$key - 1];
                    $result[$i][] = $row;
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