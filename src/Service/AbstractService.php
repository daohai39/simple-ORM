<?php

namespace App\Service;

use BlogModelMapper;
use BlogMode;

abstract class AbstractService
{
    protected $mapper;

    /*Constructor*/
    public function __construct(MapperAbstractMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /*Find an entity by its ID*/
    public function findById($id)
    {
        return $this->mapper->findById($id);
    }

    /*
    * Find the entity that meet the specified conditions
    * (find all the entities if no conditions is specified)
    */
    public function find($conditions = '')
    {
        return $this->mapper->find($conditions);
    }

    /*Insert a new entity*/
    protected function insert($entity)
    {
        return $this->mapper->insert($entity);
    }

    /*Update an existing entity*/
    public function update($entity)
    {
        return $this->mapper->update($entity);
    }

    /*Delete one or more entity*/
    public function delete($id)
    {
        return $this->mapper->delete($id);
    }
}