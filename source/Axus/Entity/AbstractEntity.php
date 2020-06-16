<?php

namespace Axus\Entity;

abstract class AbstractEntity
{

    /**
     *
     * @var array
     */
    protected $params;

    /**
     *
     * @param array $data
     */
    function __construct($params = array())
    {
        $this->params = $params;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }

    public function getData()
    {
        return $this->params;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function reset()
    {
        $this->params = array();
    }

    public function getParam($key)
    {
        return $this->params[$key];
    }
}
