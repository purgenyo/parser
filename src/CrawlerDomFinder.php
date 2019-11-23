<?php

namespace Website\HtmlParser;


class CrawlerDomFinder extends HtmlFinder
{

    public function __construct($content)
    {
        parent::__construct($content);
        $this->setFinderComponent($this->createComponent());
    }

    /**
     * Создание компонента
     *
     * @return CrawlerAdapter
     */
    private function createComponent()
    {
        $component = new CrawlerAdapter;
        $component->setContent($this->getData());
        return $component;
    }

}
