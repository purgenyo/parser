<?php

use PHPUnit\Framework\TestCase;

class NodeConfigTest extends TestCase
{

    public function testConstruct()
    {
        $object = new \Website\HtmlParser\NodeConfig('test', 'item');
        $this->assertEquals($object->getName(), 'test');
        $this->assertEquals($object->getRoute(), 'item');
    }

}