<?php

namespace Website\HtmlParser;

/**
 * Interface HtmlFinderComponentInterface
 * @package Website\HtmlParser
 */
interface HtmlFinderComponentInterface
{


    /**
     * Поиск первого узла
     *
     * @param NodeConfigInterface $node
     * @return mixed
     */
    public function findFirst(NodeConfigInterface $node);

    /**
     * Поиск всех узлов
     *
     * @param NodeConfigInterface $node
     * @return array
     */
    public function findAll(NodeConfigInterface $node);

}