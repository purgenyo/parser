<?php

namespace Website\HtmlParser\Rbc;


interface ArticleStrategy
{

    /**
     * Возращает необходимый механизм для получения публикации
     *
     * @param string $content
     * @return RbcArticleInterface|null
     */
    public function findStrategy(string $content): ?RbcArticleInterface;

    /**
     * Возвращает массив RbcArticleInterface
     *
     * @return RbcArticle[]
     */
    public function getStrategyList();

}