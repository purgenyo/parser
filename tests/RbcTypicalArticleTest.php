<?php

use PHPUnit\Framework\TestCase;
use Website\HtmlParser\Rbc\RbcArticle;

class RbcTypicalArticleTest extends TestCase
{

    protected $content_typical;

    protected $content_non_typical;

    public function setUp()
    {
        $this->content_typical = file_get_contents(__DIR__ . '/dataset/typical_article.html');
        $this->content_non_typical = file_get_contents(__DIR__ . '/dataset/test_nodes.html');
        $this->content_non_typical = file_get_contents(__DIR__ . '/dataset/test_nodes.html');
    }

    public function testIsArticle()
    {
        $article = new RbcArticle;

        $typical_result = $article->isArticle($this->content_typical);
        $non_typical_result = $article->isArticle($this->content_non_typical);

        $this->assertTrue($typical_result);
        $this->assertFalse($non_typical_result);
    }

    public function testArticleItem()
    {
        $article = new RbcArticle;

        $typical_result = $article->getArticle($this->content_typical);

        $this->assertEquals('test_title', $typical_result->title);
        $this->assertEquals('test_image.jpg', $typical_result->main_image);
        $this->assertEquals('overview', $typical_result->overview);
        $this->assertTrue(md5($typical_result->content) == '1cf25eb2c162df64c312e69df6a197ec');

    }


}