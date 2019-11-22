<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.11.2019
 * Time: 14:40
 */

namespace Website\HtmlParser;


class NodeConfig implements NodeConfigInterface
{

    /** Имя ноды*/
    private $name;

    /** Путь до ноды*/
    private $route;

    /**
     * NodeConfig constructor.
     *
     * @param $name
     * @param string $route
     */
    public function __construct($name, string $route)
    {
        $this->setName($name);
        $this->setRoute($route);
    }

    private function setName($name)
    {
        $this->name = $name;
    }

    private function setRoute(string $route)
    {
        $this->route = $route;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getRoute(): string
    {
        return $this->route;
    }
}