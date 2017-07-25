<?php

namespace App\Model;

use BlogModelProxy;

abstract class AbstractEntity 
{
    protected $values = array();
    protected $allowedFields = array();

    /*Constructor*/ 
    public function __construct(array $fields)
    {
        foreach($fields as $name => $value) {
            $this->$name = $value;
        }
    }

    /*Assign value to a specific field via the corresponding mutator*/
    public function set($name, $value)
    {
        if(!in_array($name, $this->allowedFields)) {
            throw new InvalidArgumentsException("The field ". $name . " is not allowed for this entity");
        }
        $mutator = 'set' . ucfirst($name);
        if(method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);
        } else {
            $this->values[$name] = $value;
        }
    }

    /*Get the value assigned to the specific field via the corresponding getter*/
    public function get($name) 
    {
        if(!in_array($name, $allowedFields)) {
            throw new InvalidArgumentsException("The field " . $name . " is not allowed for this entity");
        }
        $accessor  = 'get' . ucfirst($name);
        if(method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
           return $this->$accessor($name);
        }
        if(!isset($this->values[$name])) {
            throw new InvalidArgumentsException('The field ' . $name . ' has not been set for this entity yet.'); 
        }
        // if the field is a proxy for an entiy, load the   entity via its load() method
        $field = $this->values['name'];
        if ($fields instanceof ProxyEntity)) {
            $field = $field->load();
        }   
        return $field;
    }

    /*Check if the specified field has been assigned to the entity*/
    public function isset($name)
    {
        if(!in_array($name, $this->allowedFields)) {
            throw new InvalidArgumentsException("The field " . $name . " is not allowed for this entity");
        }
        return isset($this->values[$name]);
    }

    /*Unset the specified field from the entity*/
    public function unset($name)
    {
        if(!in_array($name, $this->allowedFields)) {
            throw new InvalidArgumentsException("The field " . $name . " is not allowed for this entity");
        }
        if(isset($this->values['name'])) {
            unset($this->values['name']);
            return true;
        }
        return false;
    }

    /*Get an associative array with the values assigned to the fields of the entity*/
    public function toArray()
    {
        return $this->values;
    }
}