<?php

declare(strict_types=1);

// Некий класс ответа на запрос из нашего фреймворка. Приведен просто для референса
class Response
{
    public function __construct(
        public string $content,
        public int $code
    ) {
    }

    // ...
}

class LogController
{
    /**
     * Метод numberOfErrors возвращает в ответ json, со следующей структурой:
     * {
     *   "found_errors": <int>
     * }
     *
     * Он выполняется максимум X мс, которые мы можем задать в конфиге.
     * Он проходится по файлу log.txt и ищет там ошибки с кодом $errorCode.
     * Он возвращает количество найденных ошибок за период времени.
     *
     * На сервере для PHP процесса выделяется 250 mb памяти. Размер файла log.txt - 10gb
     * Файл расположен в корне (/log.txt), его содержимое:
     * <timestamp>;<error_code>
     */
    #[Route('numberOfErrors/{errorCode}')]
    public function numberOfErrors(int $errorCode): Response
    {
        // написать имплементацию метода

        return new Response('', 200);
    }
}
