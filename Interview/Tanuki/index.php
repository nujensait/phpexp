<?php

Class Currency
{
    private $name;

    public function getId() : int {

    }
}

Class ExchangeRate {

    const ERROR_RATE = -1;

    const DEFAULT_RATES = [
        // ...
    ];

    public function getCurrencyExchangeRate(Currency $currency1, Currency $currency2) : float {
        $src = new dataSource();
        $res = $src->getRate($currency1->getId(), $currency2->getId());

        if($res) {
            return $res;
        }

        // refresh
        $parent = $this->getParentSource();
        $rate = $parent->getExchageRate($currency1, $currency2);
        if($rate) {
            $src->setRate($currency1->getId(), $currency2->getId(), $rate);
            $childs = $this->getChilsSources();
            foreach($childs as $child) {
                $child->setRate($currency1->getId(), $currency2->getId(), $rate);
            }
            return $rate;
        }

        return self::ERROR_RATE;
    }

    public function getParentSource() {
        //
        $obj2 = null;

        return $obj2;
    }
}

Class ExchangeClientHttp extends ExchangeRate
{
    public function getRate() {
        $guzzle = new GuzzleHttpClient();
        $params = [];
        $res = $guzzle->request($params);
        return $res;
    }

    public function setRate()
    {
        return null;
    }

    public function getCurrencyExchangeRate(Currency $currency1, Currency $currency2) : float {
        $res = null;
        // http reqyest
        return $res;
    }
}

Class ExchangeClienDb extends ExchangeRate
{
    public function setRate(Currency $currency1, Currency $currency2, float $rate) : void
    {
        $db = new DbConnetion();
        $sql = "UPDATE rates ...";
    }

    public function getCurrencyExchangeRate(Currency $currency1, Currency $currency2) : float {
        $res = null;
        // http reqyest
        $db = new DbConnetion();
        $cacheDb = $db->get($currency1->getId(), $currency2->getId());

        if($cacheDb) {
            return $cacheDb;
        }

        $objHttp      = new ExchangeClientHttp();
        $rateHttp = $this->getExchageRate($objHttp, $currency1, $currency2);
        if($rateHttp) {
            $db->updateRate($currency1->getId(), $currency2->getId(), $rateHttp);
            return $rateHttp;
        }

        return self::ERROR_RATE;
    }

    public function updateRate() {
        // save into DB
        // save into cache
    }
}

Class ExchangeClientCache extends ExchangeRate
{
    public function getCurrencyExchangeRate(Currency $currency1, Currency $currency2) : float {
        // http reqyest
        // ...
        $cache = new Predis\Client();
        $cacheRate = $cache->get($currency1->getId(), $currency2->getId());

        if($cacheRate) {
            return $cacheRate;
        }

        $objDb      = new ExchangeClientDb();
        $rateDb = $this->getExchageRate($objDb, $currency1, $currency2);
        if($rateDb) {
            $this->setRate($currency1, $currency1, $rateDb);
            return $rateDb;
        }

        return self::ERROR_RATE;
    }

    public function setRate(Currency $currency1, Currency $currency2, floar $rate) {
        $cache = new Predis\Client();
        $cache->set($currency1->getId(), $currency2->getId(), $rate);
    }
}

Class Exchange
{
    public function getExchageRate($obj, Currency $currency1, Currency $currency2) {
        $res = $obj->getCurrencyExchangeRate($currency1, $currency2);
        if($res !== null) {
            return $res;
        }
        return null;
    }

    private function setRate($obj, $currency1, $currency2, $res)
    {
        $obj->setRate($currency1, $currency2, $res);
    }

    public function getRate(Currency $currency1, Currency $currency2) {
        // read from cache
        $objCache   = new ExchangeClientCache();
        $objDb      = new ExchangeClientDb();
        $objHttp    = new ExchangeClientHttp();
        $arr        = [$objCache, $objDb, $objHttp];

        $res = $this->getExchageRate($objCache, $currency1, $currency2);

/*
        if($res !== null) {
            return $res;
        } else {
            $res = $this->getExchageRate($objDb, $currency1, $currency2);
            if($res !== null) {
                $this->setRate($objCache, $currency1, $currency2, $res);
                return $res;
            } else {
                $res = $this->getExchageRate($objHttp, $currency1, $currency2);
                if($res !== null) {
                    $this->setRate($objCache, $currency1, $currency2, $res);
                    $this->setRate($objDb, $currency1, $currency2, $res);
                    return $res;
                } else {
                    $default_rate = ExchageRate::DEFAULT_RATES[$currency1->getId(), $currency2->getId()];
                    return $default_rate ?: null;
                }
            }
        }
*/
        return $res ?: Exc ;
    }
}