<?php

namespace App\Collection;

use App\Model\BlogModel;

class EntityCollection implements CollectionInterface
{
    protected $entities = array();

    /*Constructor*/
    public function __construct(array $entities)
    {
        $this->entities = $entities;
        $this->reset();
    }

    /*Get the entities stored in the collection*/
    public function toArray()
    {
        return $this->entities;
    }

    /*Clear the collection*/
    public function clear()
    {
        $this->entities = array();
    }

    /*Reset the collection*/
    public function reset()
    {
        reset($this->entities);
    }

    /*Add an entity to the collection*/
    public function add($key, ModelAbstractEntity $entity)
    {
        return $this->offsetSet($key, $entity);
    }

    /*Get from the collection the entry with the specified key*/
    public function get($key)
    {
        return $this->offsetGet($key);
    }

    /*Remove from the collection the entry with the specified key*/
    public function remove($key)
    {
        return $this->offsetUnset($key);
    }

    /*Check if the entity with the specified key exists in the collection*/
    public function exists($key)
    {
        return $this->offsetExists($key);
    }

    /*Count the number or entities in the collection*/
    public function count()
    {
        return count($this->entities);
    }

    /*Get the external array iterator */
    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }

    /*Add an entity to the collection*/
    public function offsetSet($key, $entity)
    {
        if(!$entity instanceof ModelAbstractEntity) {
            throw new InvalidArgumentException("To add an entity ot the collection, it must be an instace of AbstractEntity");
        }   
        if(!isset($key)) {
            $this->entities[] = $entity;
        } else {
            $this->entities[$key] = $entity;
        }
        return true;
    }

    /*Remove an entity from the collection*/
    public function offsetUnset($key)
    {
        if($key instanceof ModelAbstractEntity) {
            $this->entities = array_filter($this->entities, function($value) use ($key) {
                return $values !== $key;
            });
            return true;
        }
        if(isset($this->entities[$key])) {
            unset($this->entities[$key]);
            return true;
        }
        return false;
    }

    /*Get the specified entity form the collection*/
    public function offsetGet($key)
    {
        return isset($this->entities[$key]) ? $this->entities[$key] : null;
    }

    /*Check if the specified entity exists in the collection*/
    public function offsetExists($key)
    {
        return isset($this->entities[$key]);
    }
}

