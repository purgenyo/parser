<?php

namespace Website\HtmlParser;

/**
 * Конфигурация поиска по html содержимому
 *
 * Interface HtmlFinderInterface
 * @package Website\HtmlParser
 */
interface HtmlFinderInterface
{

    /**
     * @return mixed
     */
    public function getData();

    /**
     * Добавляет ноду
     *
     * @param NodeConfigInterface $node
     * @return mixed
     */
    public function addNode(NodeConfigInterface $node);

    /**
     * Предпренимает попытку получить ноду по имени
     *
     * @param $name
     * @return null|NodeConfigInterface
     */
    public function getNode($name): ?NodeConfigInterface;

    /**
     * Возвращает список нод
     *
     * @return NodeConfigInterface[]
     */
    public function getNodes();

    /**
     * @param HtmlFinderComponentInterface $component
     */
    public function setFinderComponent(HtmlFinderComponentInterface $component);

    /**
     * @return HtmlFinderComponentInterface
     */
    public function getFinderComponent(): HtmlFinderComponentInterface;

}