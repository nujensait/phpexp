<?php


abstract class PageRenderer
{
    // template method
    final public function render(){
        $this->loadContext();
        $this->onPreLoad();
        $this->load();
        $this->onPostLoad();
    }

    abstract public function loadContext();
    abstract public function load();

    public function onPreLoad(){}
    public function onPostLoad(){}
}