<?php

namespace App\Model;

use BlogModelProxy;

class Entry extends AbstractEntity 
{
    protected $allowedFields = array(
        'id',
        'title',
        'content',
        'comments'
    );

    /*Set the entry ID*/
    public function setId($id)
    {
        if(!filter_var($id, FILTER_VALIDATE_INT, array(
            'options' => array(
                    'min_range' => 1,
                    'max_range' => 65535,
                ),
        ))) {
            throw new InvalidArgumentException("The entry ID is invalid");
        }
        $this->values['id'] = $id;
    }

    /*Set the entry title*/
    public function setTitle($title)
    {
        if(!is_string($title) || strlen($title) < 2 || strlen($title) > 32) {
            throw new InvalidArgumentException("The title of the entry is not valid");
        }
        $this->values['title'] = $title;
    }

    /*Set the entry content*/
    public function setContent($content)
    {
        if(!is_string($content) || empty($content))
        {
            throw new InvalidArgumentException("The content of the entry is not valid");
        }
        $this->values['content'] = $content;
    }

    /*
    * Set the comments for the blog entry
    * (assigns a ProxyCollection for lazy loading comments)
    */
    public function setComments(ProxyCollection $comments)
    {
        $this->values['comments'] = $comments;
    }
}