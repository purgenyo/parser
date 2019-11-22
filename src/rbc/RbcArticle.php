<?php

namespace Website\HtmlParser\Rbc;

use Website\HtmlParser\HtmlFinderInterface;
use Website\HtmlParser\NodeConfig;

/**
 * Парсер типичной публикации rbc
 *
 * Class RbcArticleParser
 * @package Website\HtmlParser
 */
class RbcArticle extends AbstractRbcArticle
{

    /**
     * @param string $body
     * @return ArticleItem
     */
    public function getArticle(string $body): ArticleItem
    {
        $article = new ArticleItem();
        $article->original_page = $body;

        $finder = $this->getHtmlFinder($body);
        /* Конфигурация, добавления нод для поиска */
        $this->configureFinder($finder);
        $finder_component = $finder->getFinderComponent();

        /**
         * Значения заголовка, и вступления всегда в первой ноде
         */
        foreach (['title', 'overview'] as $node_name) {
            if (($node = $finder->getNode($node_name)) && ($dom_node = $finder_component->findFirst($node))) {
                /* Имена нод совпадают с именами ArticleItem */
                $article->{$node_name} = $dom_node->nodeValue;
            }
        }

        /**
         * Поиск основного изображения
         */
        if (($node = $finder->getNode('main_image')) && ($dom_node = $finder_component->findFirst($node))) {
            $article->main_image = $dom_node->getAttribute('src');
        }

        /**
         * Собираем контент из нод, которые нашли
         */
        if (($node = $finder->getNode('content')) && ($dom_nodes = $finder_component->findAll($node))) {
            foreach ($dom_nodes as $dom_node) {
                $article->content .= $dom_node->nodeValue;
            }
        }

        return $article;
    }

    /**
     * Проверяем есть ли "типичный" заголовок и "типичное" содержимое,
     *
     * @param string $body
     * @return bool
     */
    public function isArticle(string $body): bool
    {
        $finder = $this->getHtmlFinder($body);
        $this->configureFinder($finder);
        $finder_component = $finder->getFinderComponent();

        $title_exist = ($node = $finder->getNode('title')) && ($dom_node = $finder_component->findFirst($node));
        $content_exist = ($node = $finder->getNode('content')) && ($dom_nodes = $finder_component->findAll($node));

        return $title_exist && $content_exist;
    }

    private function configureFinder(HtmlFinderInterface $finder)
    {
        $finder->addNode(new NodeConfig('title', '.article__header .js-slide-title'));
        $finder->addNode(new NodeConfig('main_image', '.article__main-image img'));
        $finder->addNode(new NodeConfig('overview', '.article__text__overview span'));
        $finder->addNode(new NodeConfig('content', '.article__content p, .article__content li'));
    }

}