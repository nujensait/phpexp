<?php

declare(strict_types=1);

// Некий класс ответа на запрос из нашего фреймворка. Приведен просто для референса
class Response
{
    public function __construct(
        public string $content,
        public int    $code
    )
    {
    }

    /**
     * @hint added this method for debug
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(['content' => $this->content, 'code' => $this->code]);
    }
}

class LogController
{
    private $f;     // log file descriptor
    private const FNAME = "log.txt";
    private const TIMEOUT = 100;

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
        $cnt = 0;

        $fname = self::FNAME;

        if(!file_exists($fname)) {
            $json = json_encode(['error' => 'file not found']);
            return new \Response($json, 500);
        }

        if($this->f === null) {
            $this->f = fopen($fname, "r");
        }

        $ts = (microtime(true));

        // написать имплементацию метода
        while(!feof($this->f)) {
            $line = fgets($this->f);       // read new line
            $exp = explode(";", $line);
            $errCode = $exp[1] ?? null;
            if($errCode == $errorCode) {
                $cnt++;
            }

            // script execution time limit
            $time = (microtime(true) - $ts);
            if($time >= self::TIMEOUT) {
                break;
            }
        }

        fclose($this->f);

        $json = json_encode(['found_errors' => $cnt]);

        return new Response($json, 200);
    }
}

$log = new LogController();
$cnt = $log->numberOfErrors(2);
echo $cnt;

