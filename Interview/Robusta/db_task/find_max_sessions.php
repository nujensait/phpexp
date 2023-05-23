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
 * @param $date
 * @return mixed|null
 */
function getMaxUsersActivity($date)
{
    $query = 'SELECT * FROM `sessions` WHERE DATE(`login_time`) = :date ORDER BY login_time ASC';
    $db = new DB();
    $users = $db->query($query, [':date' => $date]);

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
