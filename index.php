<?php

require './vendor/autoload.php';

use Website\HtmlParser\Rbc\GuzzleRbcArticleList;

$processor = new GuzzleRbcArticleList;



$processor->fetchList();
$processor->prepareList();
$a = $processor->getArticleList();
$m = 1;
