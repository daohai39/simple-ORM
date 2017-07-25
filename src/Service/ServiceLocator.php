<?php

namespace App\Service;

use BlogInjector;

class ServiceLocator
{
    protected $injectors = array();
    protected $services = array();

    /*Add an injector*/
    public function addInjector($key, InjectorInterfaceInjector $injector)
    {
        if(!isset($this->injectors[$key])) {
            $this->injectors[$key] = $injector;
            return true;
        }
        return false;
    }

    /*Add multple injector*/
    public function addInjectors(array $injectors)
    {
        foreach ($injectors as $key => $injector) {
            $this->addInjector($key, $injector);
        }
        return $this;
    }

    /*Check if the specified injector exists*/
    public function injectorExists($key)
    {
        return isset($this->injectors[$key]);
    }

    /*Get the specified injector*/
    public function getInjector($key)
    {
        return isset($this->injector[$key]) ? $this->injector[$key] : null;
    }

    /*Add a single service*/
    public function addService($key, AbstractService $service)
    {
        if (!isset($this->services[$key])) {
            $this->services[$key] = $service;
            return true;
        }
        return false;
    }

    /*Add multiple services*/
    public function addServices(array $services)
    {
        foreach ($services as $key => $service) {
            $this->addService($key, $service);
        }
        return $this;
    }

    /*Check if the specified service exists*/
    public function serviceExists($key)
    {
        return isset($this->services[$key]);
    }

    /*
    * Get the specified service
    * If the service has been previously injected or created, get it from the $services array
    * Otherwise, make the associated injector create the service and save it the $service array
    */
    public function getService($key)
    {
        if (isset($this->services[$key])) {
            return $this->services[$key];
        }
        if (!isset($this->injector[$key])) {
            throw new RuntimeException("The specified service cannot be created because the associated injector does not exist");
        }
        $service = $this->getInjector($key)->create();
        $this->addService($key, $service);
        return $service;
    }
}