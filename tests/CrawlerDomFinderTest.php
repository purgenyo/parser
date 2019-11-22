<?php

use PHPUnit\Framework\TestCase;
use Website\HtmlParser\CrawlerDomFinder;
use Website\HtmlParser\HtmlFinderComponentInterface;
use Website\HtmlParser\NodeConfig;
use Website\HtmlParser\NodeConfigInterface;

class CrawlerDomFinderTest extends TestCase
{

    protected $content;

    public function setUp()
    {
        $this->content = file_get_contents(__DIR__ . '/dataset/test_nodes.html');
    }

    public function testData()
    {
        $md5 = md5($this->content);
        $object = new CrawlerDomFinder($this->content);
        $this->assertEquals($md5, md5($object->getData()));
    }

    public function testNode()
    {
        $object = new CrawlerDomFinder($this->content);
        $node = new NodeConfig('name', 'route');
        $object->addNode($node);
        $node = $object->getNode('name');
        $this->assertEquals(true, $node instanceof NodeConfigInterface);
        $this->assertEquals(true,  is_null($object->getNode('null')));
        $nodes = $object->getNodes();
        $node = $nodes['name'] ?? null;
        $this->assertEquals(true, $node instanceof NodeConfigInterface);
        $this->assertEquals('route', $node->getRoute());
    }

    public function testComponent()
    {
        $object = new CrawlerDomFinder($this->content);
        $this->assertEquals(true, $object->getFinderComponent() instanceof HtmlFinderComponentInterface);
    }

}