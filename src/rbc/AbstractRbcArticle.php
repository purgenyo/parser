<?php

namespace Website\HtmlParser\Rbc;

use Website\HtmlParser\CrawlerDomFinder;
use Website\HtmlParser\HtmlFinderInterface;

abstract class AbstractRbcArticle implements RbcArticleInterface
{

    /**
     * Возвращает компонент HtmlFinderInterface
     *
     * @param $body
     * @return HtmlFinderInterface
     */
    public function getHtmlFinder($body): HtmlFinderInterface
    {
        return new CrawlerDomFinder($body);
    }

}