1. Распаковываем архив `target.zip`, заходим в каталог `target`
1. Устанавливаем зависимости командой `composer install`
1. Запускаем тестируемый проект `docker-compose up`
1. Заходим на адрес `http://localhost:7777/api/doc`, авторизуемся `admin` / `my_pass` и видим документацию API
1. Заходим в контейнер командой `docker exec -it php sh` и выполняем команду
`php bin/console doctrine:migrations:migrate` для того, чтобы накатить миграции на БД
1. Выходим из контейнера и возвращаемся обратно в корневой каталог
1. Устанавливаем необходимые пакеты командой
    ```shell script
    composer require --dev codeception/codeception codeception/module-phpbrowser codeception/module-rest codeception/module-asserts
    ```
1. Создаём файл `codeception.yml`
    ```yaml
    namespace: Tests
    paths:
        tests: tests
        output: tests/_output
        data: tests/_data
        support: tests/_support
        envs: tests/_envs
    actor_suffix: Tester
    extensions:
        enabled:
            - Codeception\Extension\RunFailed
    ```
1. Создаём файл `tests/acceptance.suite.yml`
    ```yaml
    actor: AcceptanceTester
    modules:
        enabled:
            - REST:
                  url: http://localhost:7777
                  depends: PhpBrowser
                  part: Json
            - Asserts
    ```
1. Собираем актор командой `vendor/bin/codecept build`
1. В файле `composer.json` исправляем секцию `autoload-dev`
    ```json
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/acceptance"
        }
    },
    ```
1. Создаём файл `tests/acceptance/UserCest.php`
    ```php
    <?php
    
    namespace Tests;
    
    use Codeception\Util\HttpCode;
    
    class UserCest
    {
        public function testAddUserUnauthorized(AcceptanceTester $I): void
        {
            $I->sendPost('/api/v1/user', ['login' => 'Terry Pratchett']);
            $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
        }
    }
    ```
1. Запускаем тесты командой `vendor/bin/codecept run`
1. Добавляем в класс `App\Tests\AcceptanceTester` новые методы:
    ```php
   
    public function amAdmin(): void
    {
        $this->amHttpAuthenticated('admin', 'my_pass');
    }
    
    public function amUser(): void
    {
        $this->amHttpAuthenticated('user', 'other_pass');
    }

    public function canSeeForbiddenResponse(): void
    {
        $this->canSeeResponseContainsJson(['message' => 'Access denied']);
        $this->canSeeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function canSeeBadRequestResponse(): void
    {
        $this->canSeeResponseContainsJson(['success' => false]);
        $this->canSeeResponseMatchesJsonType(['success' => 'boolean']);
        $this->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
    ```
1. В классе `Tests\UserCest` добавляем новые тесты:
    ```php
    public function testAddUserAsUser(AcceptanceTester $I): void
    {
        $I->amUser();
        $I->sendPost('/api/v1/user', ['login' => 'Terry Pratchett']);
        $I->canSeeForbiddenResponse();
    }

    public function testAddUserAsAdmin(AcceptanceTester $I): void
    {
        $I->amAdmin();
        $I->sendPost('/api/v1/user', ['login' => 'Terry Pratchett']);
        $I->canSeeResponseContainsJson(['success' => true]);
        $I->canSeeResponseMatchesJsonType(['success' => 'boolean', 'user_id' => 'integer:>0']);
        $I->canSeeResponseCodeIs(HttpCode::OK);
    }

    public function testAddUserBadRequest(AcceptanceTester $I): void
    {
        $I->amAdmin();
        $I->sendPost('/api/v1/user');
        $I->canSeeBadRequestResponse();
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run`
1. Добавляем в класс `App\Tests\AcceptanceTester` новый метод:
    ```php
    public function haveUser(string $login): int
    {
        $this->amAdmin();
        $this->sendPost('/api/v1/user', ['login' => $login]);
        return $this->grabDataFromResponseByJsonPath('user_id')[0];
    }
    ```
1. Создаём файл `tests/acceptance/SubscriptionCest.php`
    ```php
    <?php
    
    namespace Tests;
    
    use Codeception\Util\HttpCode;
    
    class SubscriptionCest
    {
        public function testAddSubscriptionUnauthorized(AcceptanceTester $I): void
        {
            $I->sendPost('/api/v1/subscription', ['authorId' => 1, 'followerId' => 2]);
            $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
        }
    
        public function testAddSubscriptionAsAdmin(AcceptanceTester $I): void
        {
            $authorId = $I->haveUser('Lewis Carroll');
            $followerId = $I->haveUser('Follower #1');
            $I->amAdmin();
            $I->sendPost('/api/v1/subscription', ['authorId' => $authorId, 'followerId' => $followerId]);
            $I->canSeeForbiddenResponse();
        }
    
        public function testAddSubscriptionAsUser(AcceptanceTester $I): void
        {
            $authorId = $I->haveUser('Lewis Carroll');
            $followerId = $I->haveUser('Follower #1');
            $I->amUser();
            $I->sendPost('/api/v1/subscription', ['authorId' => $authorId, 'followerId' => $followerId]);
            $I->canSeeResponseCodeIs(200);
            $I->canSeeResponseContainsJson(['success' => true]);
            $I->canSeeResponseMatchesJsonType(['success' => 'boolean']);
        }

        public function testAddSubscriptionBadRequest(AcceptanceTester $I): void
        {
            $I->amUser();
            $I->sendPost('/api/v1/subscription');
            $I->canSeeBadRequestResponse();
        }
    }
    ```
1. Запускаем тесты командой `vendor/bin/codecept run tests/acceptance/SubscriptionCest.php`, проверяем, что всё работает
1. Добавляем в класс `App\Tests\AcceptanceTester` новые методы:
    ```php
    public function haveSubscription(int $authorId, int $followerId): void
    {
        $this->amUser();
        $this->sendPost('/api/v1/subscription', ['authorId' => $authorId, 'followerId' => $followerId]);
    }

    /**
     * @return string[] $followerLogins
     */
    public function haveAuthorWithFollowers(string $login, array $followerLogins): int
    {
        $authorId = $this->haveUser($login);
        foreach ($followerLogins as $followerLogin) {
            $followerId = $this->haveUser($followerLogin);
            $this->haveSubscription($authorId, $followerId);
        }
        
        return $authorId;
    }

    public function seeCountItemsInResponseByJsonPath(string $path, int $count): void
    {
        $response = json_decode($this->grabResponse(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertCount($count, $response[$path]);
    }
    ```
1. Добавляем новые тесты в класс `Tests\SubscriptionCest`
    ```php
    public function testListFollowersUnauthorized(AcceptanceTester $I): void
    {
        $I->sendGet('/api/v1/subscription/list-by-author?authorId=1');
        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
    
    public function tesListFollowersAsAdmin(AcceptanceTester $I): void
    {
        $authorId = $I->haveAuthorWithFollowers('John Smith', ['Some follower']);
        $I->amAdmin();
        $I->sendGet("/api/v1/subscription/list-by-author?authorId=$authorId");
        $I->canSeeForbiddenResponse();
    }
    
    public function testListFollowersAsUser(AcceptanceTester $I): void
    {
        $follower1 = 'Jake';
        $follower2 = 'Harry';
        $follower3 = 'Susan';
        $follower4 = 'Richard';
        $follower5 = 'Michael';
        $author1Id = $I->haveAuthorWithFollowers('Joan Rowling', [$follower1, $follower2, $follower3]);
        $author2Id = $I->haveAuthorWithFollowers('Douglas Adams', [$follower4, $follower5]);
        $I->amUser();
        $I->sendGet("/api/v1/subscription/list-by-author?authorId=$author1Id");
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseContainsJson(['login' => $follower1]);
        $I->canSeeResponseContainsJson(['login' => $follower2]);
        $I->canSeeResponseContainsJson(['login' => $follower3]);
        $I->seeCountItemsInResponseByJsonPath('followers', 3);
        $I->sendGet("/api/v1/subscription/list-by-author?authorId=$author2Id");
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseContainsJson(['login' => $follower4]);
        $I->canSeeResponseContainsJson(['login' => $follower5]);
        $I->seeCountItemsInResponseByJsonPath('followers', 2);
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/acceptance/SubscriptionCest.php`, проверяем, что всё работает
1. Добавляем в класс `App\Tests\AcceptanceTester` новые методы:
    ```php
    /**
     * @return string[] $authorLogins
     */
    public function haveFollowerWithAuthors(string $login, array $authorLogins): int
    {
        $followerId = $this->haveUser($login);
        foreach ($authorLogins as $authorLogin) {
            $authorId = $this->haveUser($authorLogin);
            $this->haveSubscription($authorId, $followerId);
        }

        return $followerId;
    }
    ```
1. Добавляем новые тесты в класс `Tests\SubscriptionCest`
    ```php
    public function testListAuthorsUnauthorized(AcceptanceTester $I): void
    {
        $I->sendGet('/api/v1/subscription/list-by-follower?authorId=1');
        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function tesListAuthorsAsAdmin(AcceptanceTester $I): void
    {
        $followerId = $I->haveAuthorWithFollowers('John Smith', ['Some follower']);
        $I->amAdmin();
        $I->sendGet("/api/v1/subscription/list-by-follower?followerId=$followerId");
        $I->canSeeForbiddenResponse();
    }

    public function testListAuthorsAsUser(AcceptanceTester $I): void
    {
        $author1 = 'Leo Tolstoy';
        $author2 = 'Anton Chekhov';
        $author3 = 'Fyodor Dostoevsky';
        $follower1Id = $I->haveFollowerWithAuthors('Peter', [$author3, $author1]);
        $follower2Id = $I->haveFollowerWithAuthors('Kate', [$author2]);
        $I->amUser();
        $I->sendGet("/api/v1/subscription/list-by-follower?followerId=$follower1Id");
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseContainsJson(['login' => $author1]);
        $I->canSeeResponseContainsJson(['login' => $author3]);
        $I->haveCountItemsInResponseByJsonPath('authors', 2);
        $I->sendGet("/api/v1/subscription/list-by-follower?followerId=$follower2Id");
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseContainsJson(['login' => $author2]);
        $I->haveCountItemsInResponseByJsonPath('authors', 1);
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/acceptance/SubscriptionCest.php`, проверяем, что всё работает
1. Создаём файл `tests/acceptance/TweetCest.php`
    ```php
    <?php
    
    namespace Tests;
    
    use Codeception\Util\HttpCode;
    
    class TweetCest
    {
        public function testPostTweetUnauthorized(AcceptanceTester $I): void
        {
            $I->sendPost('/api/v1/tweet', ['authorId' => 1, 'text' => 'Some text']);
            $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
        }
    
        public function testPostTweetAsAdmin(AcceptanceTester $I): void
        {
            $authorId = $I->haveUser('Lewis Carroll');
            $I->amAdmin();
            $I->sendPost('/api/v1/tweet', ['authorId' => $authorId, 'text' => 'Tweet']);
            $I->canSeeForbiddenResponse();
        }
    
        public function testPostTweetAsUser(AcceptanceTester $I): void
        {
            $authorId = $I->haveUser('Lewis Carroll');
            $I->amUser();
            $I->sendPost('/api/v1/tweet', ['authorId' => $authorId, 'text' => 'Alice in Wonderland']);
            $I->canSeeResponseCodeIs(200);
            $I->canSeeResponseContainsJson(['success' => true]);
            $I->canSeeResponseMatchesJsonType(['success' => 'boolean']);
        }

        public function testPostTweetBadRequest(AcceptanceTester $I): void
        {
            $I->amUser();
            $I->sendPost('/api/v1/tweet');
            $I->canSeeBadRequestResponse();
        }
    }
    ```
1. Запускаем тесты командой `vendor/bin/codecept run tests/acceptance/TweetCest.php`, проверяем, что всё работает
1. Добавляем в класс `App\Tests\AcceptanceTester` новый метод:
    ```php
    public function haveTweet(int $authorId, string $text): void
    {
        $this->amUser();
        $this->sendPost('/api/v1/tweet', ['authorId' => $authorId, 'text' => $text]);
    }
    ```
1. Добавляем новые тесты в класс `Tests\TweetCest`
    ```php
    public function testGetFeedUnauthorized(AcceptanceTester $I): void
    {
        $I->sendPost('/api/v1/feed?userId=1&count=3');
        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
    
    public function testGetFeedAsAdmin(AcceptanceTester $I): void
    {
        $followerId = $I->haveUser('Victor');
        $I->amAdmin();
        $I->sendPost("/api/v1/feed?userId=$followerId&count=3");
        $I->canSeeForbiddenResponse();
    }
    
    public function testGetFeedAsUser(AcceptanceTester $I): void
    {
        $author1Id = $I->haveUser('Charles Dickens');
        $author2Id = $I->haveUser('Jerome K Jerome');
        $author3Id = $I->haveUser('Jerome Salinger');
        $followerId = $I->haveUser('Julie');
        $I->haveSubscription($author1Id, $followerId);
        $I->haveSubscription($author2Id, $followerId);
        $I->haveTweet($author1Id, 'Pickwick Papers');
        $I->haveTweet($author2Id, 'Three Men in a Boat');
        $I->haveTweet($author3Id, 'Catcher in the Rye');
        $I->haveTweet($author1Id, 'Oliver Twist');
        $I->haveTweet($author2Id, 'Three Men on Wheels');
        $I->sendGet("/api/v1/tweet/feed?userId=$followerId&count=2");
        $I->canSeeResponseCodeIs(200);
        $I->haveCountItemsInResponseByJsonPath('tweets', 2);
        $I->canSeeResponseContainsJson(['text' => 'Three Men on Wheels']);
        $I->canSeeResponseContainsJson(['text' => 'Oliver Twist']);
        $I->sendGet("/api/v1/tweet/feed?userId=$followerId&count=10");
        $I->canSeeResponseCodeIs(200);
        $I->haveCountItemsInResponseByJsonPath('tweets', 4);
        $I->canSeeResponseContainsJson(['text' => 'Three Men on Wheels']);
        $I->canSeeResponseContainsJson(['text' => 'Oliver Twist']);
        $I->canSeeResponseContainsJson(['text' => 'Pickwick Papers']);
        $I->canSeeResponseContainsJson(['text' => 'Three Men in a Boat']);
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/acceptance/TweetCest.php`, проверяем, что всё работает
1. Устанавливаем модуль `WebDriver` командой
    ```shell script
    composer require --dev codeception/module-webdriver
    ```
1. Создаём файл `docker-compose.yml`
    ```yaml
    version: '3.1'
    
    services:
    
      selenium-chrome:
        image: selenium/standalone-chrome
        shm_size: '2gb'
        container_name: 'selenium-chrome'
        ports:
          - 4444:4444
    ```
1. Запускаем контейнер `docker-compose up -d`
1. В файле `composer.json` исправляем секцию `autoload-dev`
    ```json
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/acceptance",
            "SeleniumTests\\": "tests/selenium"
        }
    },
    ```
1. Создаём файл `tests/selenium.suite.yml`
    ```yaml
    actor: SeleniumTester
    modules:
      enabled:
        - WebDriver:
            url: 'http://devenergy.ru'
            browser: chrome
    ```
1. Генерируем акторы командой `vendor/bin/codecept build`
1. Создаём файл `tests/selenium/DevEnergyCest.php`
    ```php
    <?php
    
    namespace SeleniumTests;
    
    use Tests\SeleniumTester;
    
    class DevEnergyCest
    {
        public function testPageTitle(SeleniumTester $I): void
        {
            $I->amOnPage('/');
            $I->seeInTitle('/dev/energy');
        }
    }
    ```
1. Запускаем тесты командой `vendor/bin/codecept run tests/selenium/DevEnergyCest.php`, проверяем, что всё работает
1. Добавляем новый тест в класс `Tests\DevEnergyCest`
    ```php
    public function testAboutPage(SeleniumTester $I): void
    {
        $I->amOnPage('/');
        $I->click('#menu-item-482');
        $I->canSee('О сайте и об мне');
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/selenium/DevEnergyCest.php`, видим ошибку, т.к. текст
   на сайте не совпадает с текстом в тесте (об мне !== обо мне)
1. Исправляем ошибку в тесте
    ```php
    public function testAboutPage(SeleniumTester $I): void
    {
        $I->amOnPage('/');
        $I->click('#menu-item-482');
        $I->canSee('О сайте и обо мне');
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/selenium/DevEnergyCest.php`, видим, что всё работает
1. Добавим ещё один тест
    ```php
    public function testFeedbackPage(SeleniumTester $I): void
    {
        $I->amOnPage('/');
        $I->click('#menu-item-491');
        $I->fillField(['name' => 'your-name'],'Me');
        $I->fillField(['name' => 'your-email'],'my@mail.ru');
        $I->click('input[type=submit]');
        $I->canSee('Спасибо за ваше сообщение');
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/selenium/DevEnergyCest.php`, видим ошибку из-за того,
   что сообщение не успело отобразиться
1. Добавим ожидание
    ```php
    public function testFeedbackPage(SeleniumTester $I): void
    {
        $I->amOnPage('/');
        $I->click('#menu-item-491');
        $I->fillField(['name' => 'your-name'],'Me');
        $I->fillField(['name' => 'your-email'],'my@mail.ru');
        $I->click('input[type=submit]');
        $I->wait(1);
        $I->canSee('Спасибо за ваше сообщение');
    }
    ```
1. Снова запускаем тесты командой `vendor/bin/codecept run tests/selenium/DevEnergyCest.php`, видим, что всё работает
