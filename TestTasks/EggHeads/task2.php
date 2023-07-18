<?php

// Сделайте рефакторинг

// ...
$questionsQ = $mysqli->query('SELECT * FROM questions WHERE catalog_id=' . $catId);
$result = array();
while ($question = $questionsQ->fetch_assoc()) {
    $userQ = $mysqli->query('SELECT name, gender FROM users WHERE id=' . (int)$question[‘user_id’]);
    $user = $userQ->fetch_assoc();
    $result[] = array('question' => $question, 'user' => $user);
    $userQ->free();
}
$questionsQ->free();
// …

//////////////////////////////////////////////////////////
// Решение:

// Используем подготовленные выражения
// для защиты от SQL-инъекций
$questionsQuery = $mysqli->prepare('SELECT * FROM questions WHERE catalog_id = ?');
$questionsQuery->bind_param('i', $catId);
$questionsQuery->execute();

$questions = $questionsQuery->get_result()->fetch_all(MYSQLI_ASSOC);

// Собираем ID пользователей в массив
$userIds = array_column($questions, 'user_id');

// Делаем запрос для пользователей с IN()
$usersQuery = $mysqli->prepare('SELECT id, name, gender FROM users WHERE id IN (?)');

// Преобразуем массив в строку для bind_param
$userIdsString = implode(',', $userIds);

$usersQuery->bind_param('s', $userIdsString);
$usersQuery->execute();

$users = $usersQuery->get_result()->fetch_all(MYSQLI_ASSOC);

// Собираем результат, связывая вопросы и пользователей
$result = [];

foreach ($questions as $question) {
    $userId = $question['user_id'];
    $user = $users[$userId];
    $result[] = ['question' => $question, 'user' => $user];
}

// Закрываем результаты запросов
$questionsQuery->close();
$usersQuery->close();

/*
Основные улучшения:
•	Использование подготовленных выражений для защиты от SQL-инъекций
•	Объединение запросов за пользователями в один запрос с IN()
•	Использование MYSQLI_ASSOC для ассоциативных массивов
•	Закрытие результатов запросов
*/