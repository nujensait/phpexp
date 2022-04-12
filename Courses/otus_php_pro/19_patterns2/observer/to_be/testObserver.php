<?php
$observer = new NewsObserver();
$news = new News();
$news->addObserver($observer);
$news->setText('Test test test');
