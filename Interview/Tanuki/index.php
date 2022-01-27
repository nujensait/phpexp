<?php

/**
 * Currence exchange rate service
 * @author Mikhail <mishaikon@gmail.com>
 * @date 2022-01-27
 * @see readme.md
 * @hint Here we are: read/update data sequentially : clientHttp => clientDb => clientCache
 * Usage/run: php index.php
 */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Class Currency
 */
class Currency
{
    private $name;
    private $id;

    public function __construct(string $code)
    {
        switch($code) {
            case "rub":
                $this->name = "Roubles";
                $this->id   = 1;
                break;
            case "usd":
                $this->name = "Dollars";
                $this->id   = 2;
                break;
            default:
                $this->name = "Unknown";
                $this->id   = 0;
                break;
        }
    }

    /**
     * Get currency Id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get currency name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Class ExchangeRate
 * (basic parent class)
 */
abstract class ExchangeRate
{
    const ERROR_RATE = 0;

    /**
     * Get exchange rate
     * @param Currency $currency1
     * @param Currency $currency2
     * @return float
     */
    public function getCurrencyExchangeRate(Currency $currency1, Currency $currency2): float
    {
        $res = $this->getRate($currency1, $currency2);

        if ($res) {
            return $res;
        }

        // get actual rate from parent source & refresh current rate
        $parent = $this->getParentSource();
        $rate   = $parent->getRate($currency1, $currency2);

        if ($rate) {
            $this->setRate($currency1, $currency2, $rate);
            // update on childs
            $childs = $this->getChildSources();
            foreach ($childs as $child) {
                $child->setRate($currency1, $currency2, $rate);
            }
            return $rate;
        }

        return self::ERROR_RATE;
    }

    /**
     * Read rate from dataSource
     * @param Currency $currency1
     * @param Currency $currency2
     * @return float
     */
    public function getRate(Currency $currency1, Currency $currency2): float
    {
        // read from cache
        $client = $this->getClient();
        $rate   = $client->get($currency1->getId(), $currency2->getId());

        if ($rate) {
            print "Rate found in ".$client->getName().": $rate \n";
            return $rate;
        }

        print "Rate is NOT found in ".$client->getName()." \n";
        print "Watch on parent source ...\n";

        $parent = $this->getParentSource();
        $rate   = $parent->getRate($currency1, $currency2);

        return $rate;
    }

    /**
     * Save rate into dataSource
     * @param Currency $currency1
     * @param Currency $currency2
     * @param floar $rate
     */
    public function setRate(Currency $currency1, Currency $currency2, float $rate) : void
    {
        $client = $this->getClient();
        $client->set($currency1->getId(), $currency2->getId(), $rate);

        print "Rate saved in ".$client->getName().": ". $currency1->getName() . " ==> " . $currency1->getName() . ": $rate \n";

        // save rates to down/below dataSources
        $childs = $this->getChildSources();
        foreach ($childs as $child) {
            $child->setRate($currency1, $currency2, $rate);
        }
    }

    /**
     * @return mixed
     */
    abstract public function getClient();

    /**
     * Get data sources above current
     * @return mixed
     */
    abstract public function getParentSource();

    /**
     * Get data souces below current
     * @return mixed
     */
    abstract public function getChildSources();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Fake Reais storage client
 * Class PredisClient
 */
class PredisClient
{
    protected $arr = [];
    protected $name = "Cache";

    /**
     * PredisClient constructor.
     */
    public function __construct() {
    }

    /**
     * Client name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get value
     * @param $key1
     * @param $key2
     * @return mixed
     */
    public function get($key1, $key2)
    {
        if (isset($this->arr[$key1][$key2])) {
            return $this->arr[$key1][$key2];
        }

        return null;
    }

    /**
     * Set value
     * @param $key1
     * @param $key2
     * @param $val
     */
    public function set($key1, $key2, $val): void
    {
        $this->arr[$key1][$key2] = $val;
    }
}

/**
 * Class DbClient
 * @hint here we are make inheritance to simplify task, this is bad idea in general (Db has it own methods)
 */
Class DbClient extends PredisClient
{
    protected $name = "Db";

    /**
     * constructor.
     */
    public function __construct() {
        // some stored rates on http
        //$this->arr[1][2] = 0.3;
        //$this->arr[2][1] = 3.3;
    }
}

/**
 * Class HttpClient
 * @hint here we are make inheritance to simplify task, this is bad idea in general (Http has it own methods)
 */
Class HttpClient extends PredisClient
{
    protected $name = "Http";

    /**
     * constructor.
     */
    public function __construct() {
        // some stored rates on http
        $this->arr[1][2] = 0.5;
        $this->arr[2][1] = 2;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Class ExchangeClientCache
 */
class ExchangeClientCache extends ExchangeRate
{
    /**
     * @return PredisClient
     */
    public function getClient()
    {
        return new PredisClient();
    }

    /**
     * Parent source for Cache is Db
     * @return ExchangeClientDb
     */
    public function getParentSource()
    {
        return new ExchangeClientDb();
    }

    /**
     * No dataSources below cache
     * @return mixed|void
     */
    public function getChildSources()
    {
        return [];
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Class ExchangeClienDb
 */
class ExchangeClientDb extends ExchangeRate
{
    /**
     * @return DbClient
     */
    public function getClient()
    {
        return new DbClient();
    }

    /**
     * Parent source for DB is Http
     * @return ExchangeClientDb
     */
    public function getParentSource()
    {
        return new ExchangeClientHttp();
    }

    /**
     * Below DB is Cache source
     * @return mixed|void
     */
    public function getChildSources()
    {
        $cacheSource = new ExchangeClientCache();

        return [$cacheSource];
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Class ExchangeClientHttp
 */
class ExchangeClientHttp extends ExchangeRate
{
    /**
     * @return HttpClient
     */
    public function getClient()
    {
        return new HttpClient();
    }

    /**
     * Save rate
     * @hint cannot save rate into external source
     * @param Currency $currency1
     * @param Currency $currency2
     * @param float $rate
     */
    public function setRate(Currency $currency1, Currency $currency2, float $rate): void
    {
        print "Rate cannot be saved via Http\n";
    }

    /**
     * Parent of http
     * @return null
     */
    public function getParentSource()
    {
        // http request don't have parent yet ...
        return null;
    }

    /**
     * Fetch dataSources below Http
     * @return array
     */
    public function getChildSources()
    {
        // Below Http is Db & Cache sources
        $cacheSource = new ExchangeClientCache();
        $dbSource    = new ExchangeClientDb();

        return [$cacheSource, $dbSource];
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Exchange
{
    /**
     * Get rate from exact data source/client
     * @param $obj
     * @param Currency $currency1
     * @param Currency $currency2
     * @return mixed|null
     */
    public function getClientExchageRate(ExchangeRate $obj, Currency $currency1, Currency $currency2)
    {
        $res = $obj->getCurrencyExchangeRate($currency1, $currency2);
        if ($res !== null) {
            return $res;
        }

        return null;
    }

    /**
     * Set exchange rate
     * @param $obj
     * @param $currency1
     * @param $currency2
     * @param $res
     */
    private function setRate($obj, $currency1, $currency2, $res)
    {
        $obj->setRate($currency1, $currency2, $res);
    }

    /**
     * Get exchange rate
     * @param Currency $currency1
     * @param Currency $currency2
     * @return int|mixed
     */
    public function getRate(Currency $currency1, Currency $currency2)
    {
        // read from cache
        $clientCache = new ExchangeClientCache();

        $res = $this->getClientExchageRate($clientCache, $currency1, $currency2);

        return $res ?: ExchangeRate::ERROR_RATE;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$chg    = new Exchange();
$curr1  = new Currency("rub");
$curr2  = new Currency("usd");
$rate   = $chg->getRate($curr1, $curr2);

print "Exchange rate for " . $curr1->getName() . " ==> " . $curr2->getName() . " is " . $rate . ".\n";
