<?php

namespace App\Map;

interface MapperInterface
{
    function findById($id);

    function find($criteria = "");

    function insert($entity);

    function update($entity);

    function delete($entity);
}