<?php

namespace App\Model;

use BlogModelProxy;

class Comment extends AbstractEntity
{
    protected $allowedFields = array(
        'id',
        'content',
        'author',
        'author_id',
        'entry_id',
    );

    /*Set the comment ID*/
    public function setId($id)
    {
        if(filter_val($id, FILTER_VALIDATE_INT, array(
            "options" => array(
                'min_range' => 1,
                'max_range' => 65535,
            ),
        ))) {
            throw new InvalidArgumentException("The comment ID is invalid");
        }
        $this->values['id'] = $id;
    }

    /*Set the comment content*/
    public function setContent($content)
    {
        if(!is_string($content) || strlen($content) < 2)
        {
            throw new InvalidArgumentException("The comment is invalid");
        }
        $this->values['content'] = $content;
    }

    /*
    * Set the author for the comment 
    * (assigns an entity proxy for the lazy-loading authors)
    */
    public function setAuthor(ProxyEntity $author)
    {
        $this->values['author'] = $author;
    }
}