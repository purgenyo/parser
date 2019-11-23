<?php

namespace Website\HtmlParser;

/**
 * Конфигурация для ноды
 * Состоит из имени ноды и местонахождения ноды
 *
 * Interface NodeConfigInterface
 * @package Website\HtmlParser\
 */
interface NodeConfigInterface
{

    /**
     * Имя ноды
     *
     * @return string|int
     */
    public function getName();

    /**
     * Путь до ноды
     *
     * @return string
     */
    public function getRoute(): string;

}