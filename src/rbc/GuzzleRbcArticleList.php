<?php

namespace Website\HtmlParser\Rbc;

use GuzzleHttp\{
    Client, ClientInterface, Exception\GuzzleException
};
use Website\HtmlParser\CrawlerDomFinder;
use Website\HtmlParser\NodeConfig;

/**
 * Получает новости с сайта rbc.ru
 * использует Guzzle
 *
 * Class GuzzleRbcArticleList
 * @package Website\HtmlParser\Rbc
 */
class GuzzleRbcArticleList implements ArticleListInterface
{

    /**
     * Базовый адрес новостей
     *
     * @var string
     */
    private $base_url = 'https://www.rbc.ru';

    /**
     * @var int
     */
    private $limit = 15;

    /**
     * Назначение публикаций
     *
     * @var string
     */
    private $route = 'all';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * url => page content
     *
     * @var array
     */
    private $article_pages_list = [];

    /**
     * Список адресов публикаций
     *
     * @var array
     */
    private $url_list = [];

    /**
     * GuzzleRbcArticleList constructor.
     *
     * @param string $base_url
     * @param int $limit
     * @param string $route
     */
    public function __construct($base_url = 'https://www.rbc.ru', $limit = 15, $route = 'all')
    {
        $this->setBaseUrl($base_url);
        $this->setLimit($limit);
        $this->setRoute($route);
        $this->client = $this->createGuzzleClient($this->getBaseUrl());
    }

    public function setBaseUrl(string $base_url)
    {
        $this->base_url = $base_url;
    }

    public function getBaseUrl()
    {
        return $this->base_url;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Подгружает список публикаций в виде адресов на них
     *
     * @return array
     */
    private function fetchList()
    {
        $list = [];
        $json_items = $this->processJsonList($this->getBody($this->getArticleListUrl()));
        foreach ($json_items as $content) {
            $html_parser = new CrawlerDomFinder($content);
            $href = $html_parser->getFinderComponent()->findFirst(new NodeConfig('href', 'a'));
            if ($href && ($href = $href->getAttribute('href'))) {
                $list[] = $href;
            }
        }
        $this->url_list = $list;
        return $this->url_list;
    }

    /**
     * Получает контент страниц по их адресам
     */
    private function prepareList()
    {
        foreach ($this->url_list as $url) {
            $this->article_pages_list[$url] = $this->getBody($url);
        }
        $this->article_pages_list = array_filter($this->article_pages_list);
    }

    /**
     * @return array|ArticleItem[]
     */
    public function getArticleList()
    {
        $this->fetchList();
        $this->prepareList();
        $count_article = 0;
        $articles = [];
        foreach ($this->article_pages_list as $href => $content) {
            if ($count_article == $this->getLimit()) {
                break;
            }
            if ($article = $this->getArticle($content)) {
                $article->page_url = $href;
                $articles[] = $article;
                $count_article++;
            }
        }
        return $articles;
    }

    /**
     * Формирует путь до анонса публикаций на главной странице
     *
     * @return string
     */
    private function getArticleListUrl()
    {
        $current_timestamp = strtotime('now UTC');
        return "/v10/ajax/get-news-feed/project/rbcnews.{$this->getRoute()}/lastDate/{$current_timestamp}/limit/{$this->getLimit()}";
    }

    private function getArticle($content): ?ArticleItem
    {
        $strategy_finder = $this->getStrategyFinder();
        if ($article = $strategy_finder->findStrategy($content)) {
            return $article->getArticle($content);
        }
        return null;
    }

    /**
     * @return ArticleStrategy
     */
    protected function getStrategyFinder(): ArticleStrategy
    {
        return new ArticleStrategyFinder([new RbcArticle]);
    }

    /**
     * Обработка json контента
     *
     * @param $content_list
     * @return array
     */
    private function processJsonList($content_list)
    {
        $json_list = [];
        $json = json_decode($content_list, true);
        foreach ($json['items'] ?? [] as $item) {
            $json_list[] = $item['html'] ?? '';
        }
        return array_filter($json_list);
    }

    /**
     * Возвращает контент по заданому адресу
     *
     * @param $url
     * @return string
     */
    protected function getBody($url)
    {
        try {
            return $this->getClient()->request('GET', $url)->getBody()->getContents();
        } catch (GuzzleException $e) {
            return '';
        }
    }

    /**
     * @return ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param $baseUrl
     * @return ClientInterface
     */
    protected function createGuzzleClient($baseUrl): ClientInterface
    {
        return new Client(['base_uri' => $baseUrl]);
    }

}