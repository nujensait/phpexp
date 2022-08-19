<?php

$content = 'Article text';

function clientCode(AbstractFactory $factory, string $content){
    $article = $factory->createArticle($content);
}

clientCode(new HtmlFactory(), $content);
clientCode(new RssFactory(), $content);
