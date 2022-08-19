<?php


final class Connection
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): Connection
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function doSomething(){

    }

    private function __clone(){}
    private function __wakeup(){}
}