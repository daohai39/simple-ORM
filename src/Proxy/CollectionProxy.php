<?php

namespace App\Proxy;

use BlogModelCollection;

class CollectionProxy extends AbstractProxy implements 
    ProxyInterface, 
    Countable, 
    IteratorAggregate
{
    protected $collection;

    /*Load the entity via the mapper find() method*/
    public function load()
    {
        if($this->collection === null) {
            $this->collection = $this->mapper->find($this->params);
            if(!$this->collection instanceof CollectionEntityCollection) {
                throw new RuntimeException("Unable to load the related collection");
            }
        }
        return $this->collection;
    }

    /*Count the number of elements in the collections*/
    public function count()
    {
        return count($this->load());
    }

    /*Load the entity collection when proxy is used in a 'foreach' construct*/
    public function getIterator()
    {
        return $this->load();
    }
}