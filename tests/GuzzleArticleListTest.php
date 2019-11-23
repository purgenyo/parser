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

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function testGuzzleTest()
    {
        $article_list = new GuzzleRbcArticleList;
        $client = $this->invokeMethod($article_list, 'getClient');
        $this->assertTrue($client instanceof ClientInterface);
    }

    public function testJsonData()
    {
        $guzzle_class = new GuzzleRbcArticleList;
        $data = $this->invokeMethod($guzzle_class, 'processJsonList', ['content_list' => $this->content]);

        $test_0 = strpos($data[0] ?? '', 'rbc.ru') == 62;
        $test_14 = strpos($data[14] ?? '', 'rbc.ru') == 40;
        $test_29 = strpos($data[29] ?? '', 'rbc.ru') == 64;

        $this->assertTrue($test_0 && $test_14 && $test_29);
    }

    public function testData()
    {
        $article_list = new GuzzleRbcArticleList('test', 10, 'nsk');
        $uri = $this->invokeMethod($article_list, 'getArticleListUrl');

        $pos_1 = strpos($uri, 'rbcnews.nsk/lastDate') !== false;
        $pos_2 = strpos($uri, 'limit/10') !== false;
        $this->assertTrue($pos_1 && $pos_2);

        $success_content = file_get_contents(__DIR__ . '/dataset/typical_article.html');

        $item = $this->invokeMethod($article_list, 'getArticle', ['content' => $success_content]);
        $item_null = $this->invokeMethod($article_list, 'getArticle', ['content' => 'test']);

        $this->assertTrue($item instanceof ArticleItem);
        $this->assertNull($item_null);

    }

}