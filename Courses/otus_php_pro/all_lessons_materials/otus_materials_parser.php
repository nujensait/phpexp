<?php

/**
 * Otus materials parser
 */

require 'vendor/autoload.php'; // автозагрузчик

// подключаем библиотеку
use GuzzleHttp\Client;

class OtusMaterialsParser
{
    private $client;

    private $cookie;

    public function __construct(string $domain)
    {
        // создаем нового клиента
        $this->client = new Client([
            'base_uri' => $domain,  // базовый uri, от него и будем двигаться дальше
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
     * @param $login
     * @param $pass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doLogin(string $login, string $pass): bool
    {
        /**
         * В метод request передается три параметра:
         * 1. Методы GET, POST
         * 2. URL на который отправляются данные формы
         * 3. forms_params - значения логина и пароля
         */
        $login = $this->client->request('POST', '/login.html', [
            'form_params' => [
                'login' => $login,
                'password' => $pass
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
        if($this->cookie) {
            $headers['Cookie'] = $this->cookie;     // cookie is required to make auth
        }

        $content = $this->client->request('GET', $url, [
          'headers' => $headers,
           /*'debug' => true*/ // если захотите посмотреть что-же отправляет ваш скрипт, расскоментируйте
        ]);

        //print $articles -> getStatusCode();

        // html код страницы со скидками, например
        $body = $content->getBody()->getContents();

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
    private function printOut(string $text) {
        echo $text . "\n";
    }

    /**
     * Parse materials on page
     * @param string $url
     */
    public function parsePage(string $url): bool
    {
        $this->printOut("Parsing page '$url' ...");

        //$body = $this->readPage($url);
        $body = $this->readFile($url);

        if(!$body) {
            return false;
        }

        //echo substr($body, 0, 500) . "..."; die();

        /**
         * Html data to parse, samples:

        <a href="#" class="learning-near__header-link js-learning-open" data-id="30855">
            <span class="learning-near__header-text">PHP WebServers</span>
            <span class="ic ic-fire learning-near__header-fire"></span>
        </a>

        <script type="text/html" data-id="182865" class="js-media-player-content">
            <div class="media-file">
                <div class="media-file__vertical">
                    <div class="media-file__vertical-box">
                        <video controls controlsList="nodownload" oncontextmenu="return false;" width="100%" height="100%" class="video-js vjs-16-9 vjs-big-play-centered" data-boomstream-src="https://play.boomstream.com/LpYDmBgv">
                           Тег video не поддерживается вашим браузером
                        </video>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" data-id="183125" class="js-media-player-content">
            <div class="media-link">
                <div class="media-link__box">
                    <div class="media-link__icon ic ic-media-file"
                        style="background-image: url(https://opengraph.githubassets.com/44788430e4956f3d199bc6b7e9bf219b6d831730d3cfaa3e5440f60fb148c58f/php/php-src);"></div>
                    <div class="media-link__text">
                        <div class="media-link__title">GitHub - php/php-src: The PHP Interpreter</div>
                        <a class="media-link__link" target="_blank" href="https://github.com/php/php-src" title="Перейти">Перейти</a>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" data-id="181340" class="js-media-player-content">
            <div class="media-file">
            <div class="media-file__box">
                <div class="media-file__icon ic ic-media-file ic-media-"></div>
                <div class="media-file__text">
                    <div class="media-file__title">Materials_07-02-2022.txt</div>
                    <a class="media-file__link" target="_blank" href="https://cdn.otus.ru/media/private/bb/cc/Materials_07_02_2022-214266-bbcc4f.txt?hash=3JjT_MM2R_wTvF9H2w5fpg&expires=1659038785" title="Скачать">Скачать</a>
                    </div>
                </div>
            </div>
         </script>
         */

        // parse headers
        $matches = [];
        preg_match_all('/<span class="learning-near__header-text">(.*?)<\/span>/', $body, $matches, PREG_SET_ORDER);
        //var_dump($matches); die();

        if(is_array($matches)) {
            foreach($matches as $match) {
                //$dom = new DOMDocument();
                //$dom->loadXML($match);

                //echo $dom->saveXML();
                //var_dump($match); die();
                $this->printOut("- " . $match[1]);
            }
        }

        return count($matches ? true : false);
    }
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

$pages = ['page_sample.html'];

$parser = new OtusMaterialsParser('');      // prod : https://otus.ru/

foreach ($pages as $pageUrl) {
    $parser->parsePage($pageUrl);
}


