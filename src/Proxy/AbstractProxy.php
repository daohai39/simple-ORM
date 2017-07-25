<?php

namespace App\Proxy;

use BlogModelMapper;

abstract class AbstractProxy
{
    protected $mapper;
    protected $params;

    /*Constructor*/
    public function __construct(AbstractMapper $mapper, $params)
    {
        if(!is_string($params) || empty($params)) {
            throw new InvalidArgumentException("The mapper parameters are invalid");
        }
        $this->mapper = $mapper;
        $this->params = $params;
    }

    /*Get the mapper*/
    public function getMapper()
    {
        return $this->mapper;
    }

    /*Get the mappet params*/
    public function getParams()
    {
        return $this->params;
    }
}