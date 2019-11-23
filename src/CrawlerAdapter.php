<?php

namespace Website\HtmlParser;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Текущая реализация выполняет поиск по css селектору
 *
 * Class CrawlerAdapter
 * @package Website\HtmlParser
 */
class CrawlerAdapter implements HtmlFinderComponentInterface
{

    private $content;

    private $parser;

    public function setContent($content)
    {
        $this->content = $content;
        $this->createParser();
    }

    public function getContent()
    {
        return $this->content;
    }

    private function find($route)
    {
        $nodes = [];
        $crawler = $this->getParser()->filter($route);

        foreach ($crawler as $crawler_node) {
            $nodes[] = $crawler_node;
        }

        return $nodes;
    }

    /**
     * Создание экземпляра crawler
     *
     * @return Crawler
     */
    public function getParser(): Crawler
    {
        return $this->parser;
    }

    private function createParser()
    {
        $this->parser = new Crawler($this->getContent());
    }

    public function findFirst(NodeConfigInterface $node)
    {
        $dom_node = $this->find($node->getRoute());
        return $dom_node[0] ?? null;
    }

    public function findAll(NodeConfigInterface $node)
    {
        return $this->find($node->getRoute());
    }
}