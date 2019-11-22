<?php

namespace Website\HtmlParser;


abstract class HtmlFinder implements HtmlFinderInterface
{

    private $nodes = [];

    private $data;

    private $component;

    public function __construct($content)
    {
        $this->data = $content;
    }

    public function getData()
    {
        return $this->data;
    }

    public function addNode(NodeConfigInterface $node)
    {
        $this->nodes[$node->getName()] = $node;
    }

    public function getNode($name): ?NodeConfigInterface
    {
        return $this->nodes[$name] ?? null;
    }

    public function getNodes()
    {
        return $this->nodes;
    }

    public function setFinderComponent(HtmlFinderComponentInterface $component)
    {
        $this->component = $component;
    }

    public function getFinderComponent(): HtmlFinderComponentInterface
    {
        return $this->component;
    }

}