<?php

namespace App\Proxy;

use BlogModel;

class EntityProxy extends AbstractProxy implements ProxyInterface
{
    protected $entity;

    /*Load an entity via  the mapper findById()  method*/
    public function load()
    {
        if($this->entity == null) {
            $this->entity = $this->mapper->findById($this->params);
            if(!$this->entity instanceof ModelAbstractEntity) {
                throw new RuntimeException("Unable to load the related entity");
            }
        }
        return $this->entity;
    }

}