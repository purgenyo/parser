<?php

namespace Website\HtmlParser\Rbc;

class ArticleItem
{

    /**
     * Заголовок публикации
     *
     * @var string
     */
    public $title = '';

    /**
     * Основное изображение из публикации
     *
     * @var string
     */
    public $main_image = '';

    /**
     * Предварительное описание
     *
     * @var string
     */
    public $overview = '';

    /**
     * Содержимое публикации
     *
     * @var string
     */
    public $content = '';

    /**
     * Оригинальный контент страницы с публикацией
     *
     * @var string
     */
    public $original_page = '';

    /**
     * Адрес публикации
     *
     * @var string
     */
    public $page_url = '';

}