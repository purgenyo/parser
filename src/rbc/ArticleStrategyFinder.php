<?php

namespace Website\HtmlParser\Rbc;


class ArticleStrategyFinder implements ArticleStrategy
{

    private $strategies = [];

    public function __construct($strategy_list)
    {
        $this->strategies = $strategy_list;
    }

    /**
     * Возращает необходимый механизм для получения публикации
     *
     * @param string $content
     * @return RbcArticleInterface|null
     */
    public function findStrategy(string $content): ?RbcArticleInterface
    {
        foreach ($this->getStrategyList() as $strategy) {
            if ($strategy->isArticle($content)) {
                return $strategy;
            }
        }
        return null;
    }

    /**
     * @return RbcArticle[]
     */
    public function getStrategyList()
    {
        return $this->strategies;
    }

}