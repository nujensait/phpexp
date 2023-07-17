<?php

namespace Sessions;

/**
 * Calc sessions DB statistics
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
            . 'FROM public.timetable '
            . 'ORDER BY id ASC ' .
            $limitStmt);

        $sessions = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $sessions[] = $row;
        }

        return $sessions;
    }

    /**
     * Get sessions stat
     * @param int $dt1
     * @param int $dt2
     * @return mixed|null
     */
    function getMaxSessionsTime(int $dt1, int $dt2)
    {
        $query = "SELECT * 
                  FROM public.timetable 
                  WHERE login_time >= :date_begin 
                    AND login_time <= :date_end
                  ORDER BY login_time ASC";

        $stmt = $this->pdo->prepare($query, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $stmt->execute([
            'date_begin' => $dt1,
            'date_end'   => $dt2,
        ]);

        $times = [];
        $result = [];
        $i = 0;

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach($rows as $key => $row) {
            $times[$key] = [
                'login' => $row['login_time'],
                'logout' => $row['logout_time']
            ];

            if (isset($times[$key - 1])) {
                $prev = $times[$key - 1];
                if ($prev['logout'] < $times[$key]['login'] && $prev['logout'] > 0) {
                    $i++;
                }
                if (($prev['login'] <= $times[$key]['logout'] && $prev['logout'] >= $times[$key]['login']) ||
                    ($prev['logout'] < 0 && $prev['login'] <= $times[$key]['login']) ||
                    ($times[$key]['logout'] < 0 && $prev['logout'] >= $times[$key]['login'])) {
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

        $result = \array_map(function ($items) use($dt2) {
            $items = \array_unique($items, \SORT_REGULAR);
            $items += [
                'count'         => \count($items),
                'period_start'  => \min(pluck($items, 'login_time')),
                'period_end'    => \min($dt2, \max(pluck($items, 'logout_time')))
            ];
            return $items;
        }, $result);

        \usort($result, function ($a, $b) {
            return ($a['count'] == $b['count'] ? 0 : ($a['count'] < $b['count'] ? 1 : -1));
        });

        return \array_shift($result);
    }
}