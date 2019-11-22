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
    public $article_pages_list = [];

    /**
     * Список адресов публикаций
     *
     * @var array
     */
    public $url_list = [];

    /**
     * GuzzleRbcArticleList constructor.
     * @param string $base_url
     * @param int $limit
     * @param string $route
     */
    public function __construct($base_url = 'https://www.rbc.ru', $limit = 30, $route = 'all')
    {
        $this->base_url = $base_url;
        $this->limit = $limit;
        $this->route = $route;
        $this->client = $this->createGuzzleClient($base_url);
    }

    /**
     * Подгружает список новостей в виде адресов на них
     *
     * @return array
     */
    public function fetchList()
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
        $this->url_list = array_filter($list);
        return $this->url_list;
    }

    /**
     * Получает контент страниц по их адресам
     */
    public function prepareList()
    {
        foreach ($this->url_list as $url) {
            $this->article_pages_list[$url] = $this->getBody($url);
        }
        $this->article_pages_list = array_filter($this->article_pages_list);
    }

    public function getArticleList()
    {
        $count_article = 0;
        $articles = [];
        foreach ($this->article_pages_list as $href => $content) {
            if ($count_article == $this->limit) {
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

    public function getArticleListUrl()
    {
        $current_timestamp = strtotime('now UTC');
        return "/v10/ajax/get-news-feed/project/rbcnews.{$this->route}/lastDate/{$current_timestamp}/limit/{$this->limit}";
    }

    public function getArticle($content): ?ArticleItem
    {
        $strategy_finder = $this->getStrategyFinder();
        if ($article = $strategy_finder->findStrategy($content)) {
            return $article->getArticle($content);
        }
        return null;
    }

    public function getStrategyFinder(): ArticleStrategy
    {
        return new ArticleStrategyFinder([new RbcArticle]);
    }

    public function processJsonList($content_list)
    {
        $json_list = [];
        $json = json_decode($content_list, true);
        foreach ($json['items'] ?? [] as $item) {
            $json_list[] = $item['html'] ?? '';
        }
        return array_filter($json_list);
    }

    public function getBody($url)
    {
        try {
            return $this->getClient()->request('GET', $url)->getBody()->getContents();
        } catch (GuzzleException $e) {
            return '';
        }
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function createGuzzleClient($baseUrl): ClientInterface
    {
        return new Client(['base_uri' => $baseUrl]);
    }

}