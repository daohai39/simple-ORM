<?php

namespace App\Map;

use BlogLibraryDatabase;
use BlogModelCollection;

abstract class AbstractMapper implements MapperInterface 
{
    protected $adapter;
    protected $entityTable;
    protected $entityClass;

    public function __construct(DatabaseAdapterInterface $adapter, array $entityOptions = array()) 
    {
        $this->adapter = $adapter;

        if(isset($entityOptions['entityTable'])) {
            $this->entityTable = $entityOptions['entityTable'];
        }

        if(isset($entityOptions['entityClass'])) {
            $this->entityClass = $entityOptions['entityClass'];
        }
        
        $this->checkEntityOptions();
    }

    /*Check the entity options have been set*/
    public function checkEntityOptions()
    {
        if(!isset($this->entityTable)) {
            throw new RuntimeException("The entity table has not been set");
        }            
        if(!isset($this->entityClass)) {
            throw new RuntimeException("The entity class has not been set");
        }
    }

    /*Get the db adapter*/
    public function getAdapter()
    {
        return $this->adapter;
    }

    /*Set the entity table*/
    public function setEntitytable($entityTable) 
    {
        if(!is_string($entityTable) || empty($entityTable)) {
            throw new InvalidArgumentException("The entity table is invalid");
        }
        $this->entityTable = $entityTable;
        return $this;
    }

    /*Get the entity table*/
    public function getEntityTable() 
    {
        return $this->entityTable;
    }

    /*Set the entity class*/
    public function setEntityClass($entityClass) 
    {
        if(!is_subclass_of($entityClass, 'BlogModelAbstractEntity')) {
            throw new InvalidArgumentException("The entity class is invalid");
        }
        $this->entityClass = $entityClass;
        return $this;
    }

    /*Get the entity class*/
    public function getEntityClass() 
    {
        return $this->entityClass;
    }

    /*Find an entity by its id*/
    public function findById($id)
    {
        $this->adapter->select($this->entityTable, "id = $id");
        if ($data = $this->adapter->fetch()) {
            return $this->createEntity($data);
        }
        return null;
    }

    /*Find an entity based on the given criteria (all entities will be fetched if no criteria
    are speicified)
    */
    public function find($conditions = "")
    {
        $collection = new EntityCollection;
        $this->adapter->select($this->entityTable, $conditions);
        while ($data = $this->adapter->fetch()) {
            $collections[] = $this->createEntity($data);
        }

        return $collection;
    }

    /*Insert a new entity into the storage*/
    public function insert($entity)
    {
        if (!$entity instanceof $this->entityClass) {
            throw new InvalidArgumentException("The entity to be inserted must be an instance of ".$this->entityClass.".")
        }
        return $this->adapter->insert($this->entityTable,$entity->toArray());
    }

    /*Update an existing entity in the storage*/
    public function update($entity) 
    {
        if(!$entity instanceof $this->entityClass) {
            throw new InvalidArgumentException("The entity to be inserted must be an instance of ".$this->entityClass.".");
        }
        $id = $entity->id;
        $data = $entity->toArray();
        unset($data['id']);
        return $this->adapter->update($this->entitytable,$data,"id = $id");
    }

    /*Delete one or more entites from the storage*/
    public function delete($id, $col="id")
    {
        if($id instanceof $this->entityClass) {
            $id = $id->id;
        }

        return $this->adapter->delete($this->entityTable, '$col = $id');
    }

    /* Reconstitute an entity with the data retrieved from the storage (implementation delegated to concrete mappers)*/
    abstract protected function createEntity(array $data);
}   

