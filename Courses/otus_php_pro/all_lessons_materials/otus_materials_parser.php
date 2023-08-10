<?php

/**
 * Otus materials parser
 *
 * This script will help you to save materials from Otus.ru site (available for you, with paid access)
 *
 * Usage example:
 * <paste proper start page url, with materials, below: $parser->parsePage('XXX');
 * php .\otus_materials_parser.php

 * Html data to parse, samples: @see sample_page_to_parse.html
 */

require 'vendor/autoload.php'; // автозагрузчик

// подключаем библиотеку
use GuzzleHttp\Client;

class OtusMaterialsParser
{
    private $client;
    private $cookie;
    private $body;

    const LOGIN         = 'mishaikon@mail.ru';
    const PASS          = '';
    const TYPE_LINK     = 'Перейти';
    const TYPE_FILE     = 'Скачать';
    const OUTPUT_FILE   = "otus_materials.txt";

    public function __construct(string $domain)
    {
        // создаем нового клиента
        $this->client = new Client([
            'base_uri' => $domain,                      // базовый uri, от него и будем двигаться дальше
            'verify' => false,                          // если сайт использует SSL, откючаем для предотвращения ошибок
            'allow_redirects' => false,                 // запрещаем редиректы
            'headers' => [                              // устанавливаем различные заголовки
                'User-Agent' => 'Mozilla/5.0 (Linux 3.4; rv:64.0) Gecko/20100101 Firefox/15.0',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Content-Type' => 'application/x-www-form-urlencoded' // кодирование данных формы, в такой кодировке браузер отсылает данные на сервер
            ]
        ]);
    }

    /**
     * Make authentification on site
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doLogin(): bool
    {
        /**
         * В метод request передается три параметра:
         * 1. Методы GET, POST
         * 2. URL на который отправляются данные формы
         * 3. forms_params - значения логина и пароля
         */
        $login = $this->client->request('POST', '/login', [
            'form_params' => [
                'login' => self::LOGIN,
                'password' => self::PASS
            ]
        ]);

        // статус код, если 200 или 302, то все норм, хотя не всегда)))
        //print($login->getStatusCode());

        // обязательно вытаскиваем cookies из запроса, без них ничего не сработает
        $this->cookie = $login->getHeaderLine('Set-Cookie');

        return ($login->getStatusCode() == 200);
    }

    /**
     * Read html page contents
     * @param string $url
     * @return string
     */
    public function readPage(string $url): string
    {
        $headers = [];
        if ($this->cookie) {
            $headers['Cookie'] = $this->cookie;     // cookie is required to make auth
        }

        $content = $this->client->request('GET', $url, [
            'headers' => $headers,
            /*'debug' => true*/ // если захотите посмотреть что-же отправляет ваш скрипт, расскоментируйте
        ]);

        //print $articles -> getStatusCode();

        // html код страницы со скидками, например
        $body = $content->getBody()->getContents();

        echo substr($body, 0, 500) . "..."; die();

        return $body;
    }

    /**
     * Read local file
     * @param string $file
     * @return string
     */
    public function readFile(string $file): string
    {
        $handle = fopen($file, "r");
        $contents = @fread($handle, filesize($file));
        @fclose($handle);

        return $contents;
    }

    /**
     * Output debug text
     */
    private function printOut(string $text)
    {
        echo $text . "\n";
    }

    /**
     * @return array
     */
    private function parseLinks(): array
    {
        $links = [];
        $this->printOut("Begin parsing links ...");

        // <a class="media-file__link" target="_blank" href="https://cdn.otus.ru/media/private/bb/cc/Materials_07_02_2022-214266-bbcc4f.txt?hash=3JjT_MM2R_wTvF9H2w5fpg&expires=1659038785" title="Скачать">Скачать</a>
        // <a class="media-link__link" target="_blank" href="https://github.com/php/php-src" title="Перейти">Перейти</a>

        preg_match_all('/<div class="media-(file|link)__title">(.*?)<\/div>\s*<a class="media-(file|link)__link" target="_blank" href="(.*?)" title="(Перейти|Скачать)">(Перейти|Скачать)<\/a>/', $this->body, $matches, PREG_SET_ORDER);

        if (is_array($matches)) {
            foreach ($matches as $match) {
                //var_dump($match); die();
                $hdrName = trim($match[2]);
                $fileName = trim($match[4]);
                $type = $match[5];

                //$this->printOut(" - " . $fileName);

                $links[] = ['name' => $hdrName, 'url' => $fileName, 'type' => $type];
            }
        } else {
            $this->printOut("Error: Links not found.");
        }

        return $links;
    }

    /**
     * Save links into file
     * @param $links
     * @return bool
     */
    private function saveLinks($links): bool
    {
        $this->printOut("Saving links into file '" . self::OUTPUT_FILE . "'...");

        if (!is_array($links) || !count($links)) {
            return false;
        }

        $i = 0;
        $fo = fopen(self::OUTPUT_FILE, "a");
        fwrite($fo, "\n\nСписок материалов:\n\n");

        foreach ($links as $link) {
            if ($link['type'] == self::TYPE_FILE) {
                fwrite($fo, "* [" . self::TYPE_FILE . "] " . $link['name'] . "\n" . $link['url'] . "\n\n");
            } else {
                fwrite($fo, "* " . $link['name'] . "\n" . $link['url'] . "\n\n");
            }
            $i++;
        }

        fclose($fo);

        $this->printOut("Done: $i links are saved.");

        return true;
    }

    /**
     * Download files stored on links
     * @param $links
     * @return bool
     */
    private function downloadLinks($links): bool
    {
        if (!is_array($links) || !count($links)) {
            return false;
        }

        foreach ($links as $link) {
            if ($link['type'] == self::TYPE_FILE) {
                $fileData = file_get_contents($link['url']);
                $fileName = $this->getUrlFilename($link['url']);
                $saveFileName = $link['name'];
                file_put_contents($saveFileName, $fileData);
                $this->printOut("Saving file '$saveFileName' ... Done");
                die();      // @fixme: error here now: access denied
            }
        }

        return true;
    }

    /**
     * Fetach filename from URL
     * Ex: https://cdn.otus.ru/media/private/89/60/25_Queues_Part_1-50919-896006.pdf?hash=55hAWx9KU00_rsrYNPfAtg&expires=1659287468 ==> 25_Queues_Part_1-50919-896006.pdf
     * @param string $url
     * @return string
     */
    public function getUrlFilename(string $url): string
    {
        $name = basename($url);

        if (strstr($name, "?")) {
            $name = strtok($name, "?");
        }

        return $name;
    }

    /**
     * Read lessons heade names
     * @return array
     */
    private function parseHeaders(): array
    {
        $matches = [];
        preg_match_all('/<span class="learning-near__header-text">(.*?)<\/span>/', $this->body, $matches, PREG_SET_ORDER);
        //var_dump($matches); die();

        $i = 0;
        $names = [];

        if (is_array($matches)) {
            foreach ($matches as $match) {
                $name = $match[1];
                $names[] = $name;
                $this->printOut(($i + 1) . ". ". $name);
                $i++;
            }
            $this->printOut("Lessons found: $i.");
        } else {
            $this->printOut("Error: Lessons headers not found.");
        }

        return $names;
    }

    /**
     * Save lessons names
     * @param array $hdrs
     * @return bool
     */
    private function saveHeaders(array $hdrs): bool
    {
        $i = 1;
        if (is_array($hdrs) || !count($hdrs)) {
            $this->printOut("Error: Lessons data is empty.");
            return false;
        }

        $fo = fopen(self::OUTPUT_FILE, "a");

        fwrite($fo, "Список лекций:\n");

        foreach ($hdrs as $lessonName) {
            $this->printOut($i . ". " . $lessonName);

            // create dir with lesson
            $dirName = $i . " - " . $lessonName;
            if (!is_dir($dirName)) {
                @mkdir($dirName);
            }

            // save lessons names into file
            fwrite($fo, $i . ". " . $lessonName . "\n");
            $i++;
        }

        fclose($fo);

        return true;
    }

    /**
     * Clean data before parser execution
     * @return bool
     */
    private function cleanData(): bool
    {
        if (is_file(self::OUTPUT_FILE)) {
            unlink(self::OUTPUT_FILE);
        }

        return true;
    }

    /**
     * Parse materials on page
     * @param string $url
     */
    public function parsePage(string $url): bool
    {
        $this->cleanData();

        $this->printOut("Parsing page '$url' ...");

        if (is_file($url)) {
            $body = $this->readFile($url);
        } else {
            $this->doLogin();
            $body = $this->readPage($url);
        }

        if (!$body) {
            $this->printOut("Error: page body is empty.");
            return false;
        }

        $this->body = $body;

        // SAVE LESSONS NAMES
        $hdrs = $this->parseHeaders();
        $this->saveHeaders($hdrs);

        // SAVE MATERIALS LINKS
        $links = $this->parseLinks();
        $this->saveLinks($links);
        $this->downloadLinks($links);

        $this->printOut("Parsing complete.");

        return count($hdrs) && count($links) ? true : false;
    }
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// debug
$parser = new OtusMaterialsParser('');
$parser->parsePage('page_sample.html');       // read local file

// prod
//$url = "https://otus.ru/learning/150123/";
//$parser = new OtusMaterialsParser($url);
//$parser->parsePage($url);                       // read remote page
