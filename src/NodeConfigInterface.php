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
     * @return string|int
     */
    public function getName();

    /**
     * @return string
     */
    public function getRoute(): string;

}