<?php

namespace App\Model;

class Author extends AbstractEntity
{
    protected $allowedFields = array(
        "id",
        "name",
        "email",
    );

    /*Set the author's ID*/
    public function setId($id)
    {
        if(!filter_val($id, FILTER_VALIDATE_INT, array(
            "options" => array(
                "min_range" => 1,
                "max_range" => 65535,
            ),
        ))) {
            throw new InvalidArgumentException("The ID of author is invalid");
        }
        $this->values['id'] = $id;
    }

    /*Set the author's name*/
    public function setName($name)
    {
        if(!is_string($name) || strlen($name) < 2)
        {
            throw new InvalidArgumentException("The name of author is invalid");
        }
        $this->values['name'] = $name;
    }

    /*Set the author's email*/
    public function setEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("The email of author is invalid");
        }
        $this->values['email'] = $email;
    }
}