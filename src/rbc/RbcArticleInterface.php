<?php

namespace Website\HtmlParser\Rbc;

/**
 * Получение публикации
 *
 * Interface RbcArticleInterface
 * @package Website\HtmlParser\Rbc
 */
interface RbcArticleInterface
{

    /**
     * Проверяет, является ли подходящей публикацией
     *
     * @param string $content
     * @return bool
     */
    public function isArticle(string $content): bool;

    /**
     * Возвращает публикацию
     *
     * @param string $content
     * @return ArticleItem
     */
    public function getArticle(string $content): ArticleItem;

}