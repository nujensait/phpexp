<?php

/**
 * Генератор случайных данных
 */
trait RandomGen
{
    public function getRandomExist()
    {
        return (rand(0, 2) == 2);
    }
}

/**
 * Единый интерфейс под разные источники данных
 */
interface DataSource {
    public function getUserData(int $userId): ?array;
    public function saveUserData(int $userId, array $data): bool;
}

/**
 * Источник данных - База данных
 */
class DatabaseSource implements DataSource
{
    use RandomGen;

    public function getUserData(int $userId): ?array
    {
        // Подключение к базе данных и выполнение запроса
        // Возвращает данные пользователя из базы данных

        if($this->getRandomExist()) {
            return [$userId, 'nameFromDB'];
        }

        return null;
    }

    public function saveUserData(int $userId, array $data): bool
    {
        // сохранение даных в БД
        return true;
    }
}

/**
 * Источник данных - Кеш
 */
class CacheSource implements DataSource
{
    use RandomGen;

    public function getUserData($userId): ?array
    {
        // Подключение к кэшу и получение данных по ключу $userId
        // Возвращает данные пользователя из кэша

        if($this->getRandomExist()) {
            return [$userId, 'nameFromCache'];
        }

        return null;
    }

    public function saveUserData($userId, $data): bool
    {
        // Подключение к кэшу и сохранение данных по ключу $userId
        return true;
    }
}

/**
 * Источник данных - API
 */
class ApiSource implements DataSource
{
    use RandomGen;

    public function getUserData($userId): ?array
    {
        // Подключение к API и получение данных пользователя по id
        // Возвращает данные пользователя из API

        if($this->getRandomExist()) {
            return [$userId, 'nameFromAPI'];
        }

        return null;
    }

    public function saveUserData($userId, $data): bool
    {
        // Сохранение данных в АПИ
        return true;
    }
}

class DataRetriever
{
    private $database;
    private $cache;
    private $api;

    public function __construct(DatabaseSource $database, CacheSource $cache, ApiSource $api)
    {
        $this->database = $database;
        $this->cache = $cache;
        $this->api = $api;
    }

    /**
     * Get user data
     * @param int $userId
     * @return array|null
     */
    public function getUserData(int $userId)
    {
        $data = $this->cache->getUserData($userId);
        if ($data) {
            return $data;
        }

        $data = $this->database->getUserData($userId);
        if ($data) {
            $this->cache->saveUserData($userId, $data);
            return $data;
        }

        $data = $this->api->getUserData($userId);
        if ($data) {
            $this->database->saveUserData($userId, $data);
            $this->cache->saveUserData($userId, $data);
        }

        return $data;
    }
}

//////////////////////////////////////////////////////////////////////////////////
// Пример использования

$database = new DatabaseSource();
$cache = new CacheSource();
$api = new ApiSource();

$dataRetriever = new DataRetriever($database, $cache, $api);

for($userId = 1; $userId < 10; $userId++) {
    $data = $dataRetriever->getUserData($userId);
    // Используем данные пользователя
    echo "Данные пользователя: #$userId: " . var_export($data, 1) . "\n\n";
}
