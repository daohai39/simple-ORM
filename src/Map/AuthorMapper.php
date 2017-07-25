<?php

namespace App\Map;

use BlogModel;

class AuthorMapper extends AbstractMapper
{
    protected $entityTable = 'authors';
    protected $entityclass = 'BlogModelAuthor';

    /*Create an entity with the supllied data*/
    public function createEntity(array $data)
    {
        $author = new $this->entityClass(array(
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
        ));

        return $author;
    }
}