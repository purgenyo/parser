<?php

use PHPUnit\Framework\TestCase;
use Website\HtmlParser\CrawlerAdapter;
use Website\HtmlParser\NodeConfig;

class CrawlerAdapterTest extends TestCase
{
    protected $content;

    public function setUp()
    {
        $this->content = file_get_contents(__DIR__ . '/dataset/test_nodes.html');
    }

    public function testFindOne()
    {
        $crawler = new CrawlerAdapter;
        $node = new NodeConfig('test_item', '.item testNode');
        $crawler->setContent($this->content);
        $item = $crawler->findFirst($node);
        $this->assertEquals(false, empty($item));
        $this->assertEquals('test_1', $item->nodeValue);
    }

    public function testFindAll()
    {
        $crawler = new CrawlerAdapter;
        $node = new NodeConfig('test_item', '.item testNode');
        $crawler->setContent($this->content);
        $nodes = $crawler->findAll($node);
        $this->assertEquals(false, empty($nodes));

        $result = '';

        foreach ($nodes as $node) {
            $result .= $node->nodeValue;
        }

        $this->assertEquals('test_1test_2test_3', $result);
    }

}