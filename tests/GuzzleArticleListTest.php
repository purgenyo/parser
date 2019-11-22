<?php

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Website\HtmlParser\Rbc\ArticleItem;
use Website\HtmlParser\Rbc\GuzzleRbcArticleList;

class GuzzleArticleListTest extends TestCase
{

    protected $content;

    public function setUp()
    {
        $this->content = file_get_contents(__DIR__ . '/dataset/article_json.json');
    }

    public function testGuzzleTest()
    {
        $article_list = new GuzzleRbcArticleList;
        $article_list->createGuzzleClient('https://google.com');
        $this->assertTrue($article_list->getClient() instanceof ClientInterface);
    }


    public function testJsonData()
    {
        $article_list = new GuzzleRbcArticleList;
        $data = $article_list->processJsonList($this->content);

        $test_0 = strpos($data[0] ?? '', 'rbc.ru') == 62;
        $test_14 = strpos($data[14] ?? '', 'rbc.ru') == 40;
        $test_29 = strpos($data[29] ?? '', 'rbc.ru') == 64;

        $this->assertTrue($test_0 && $test_14 && $test_29);
    }

    public function testData()
    {
        $article_list = new GuzzleRbcArticleList('test', 10, 'nsk');
        $uri = $article_list->getArticleListUrl();

        $pos_1 = strpos($uri,'rbcnews.nsk/lastDate') !== false;
        $pos_2 = strpos($uri,'limit/10') !== false;
        $this->assertTrue($pos_1 && $pos_2);

        $success_content = file_get_contents(__DIR__ . '/dataset/typical_article.html');
        $item = $article_list->getArticle($success_content) instanceof ArticleItem;
        $this->assertTrue($item);
        $this->assertNull($article_list->getArticle('null'));

        $article_list = new GuzzleRbcArticleList('test', 10, 'nsk');
        $article_list->article_pages_list = array_fill(0, 30, $success_content);
        $list = $article_list->getArticleList();
        $this->assertTrue(count($list) == 10);
    }

}