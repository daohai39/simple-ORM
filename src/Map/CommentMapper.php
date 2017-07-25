<?php

namespace App\Map;

use BlogLibraryDatabase;
use BlogModelProxy;
use App\Database\DatabaseAdapterInterface;

class CommentMapper extends AbstractMapper
{
    protected $authorMapper;
    protected $entityTable = 'comments';
    protected $entityClass = 'BlogModelComment';

    /*Constructor*/
    public function __construct(AuthorMapper $authorMapper, DatabaseAdapterInterface $adapter)
    {
        $this->authorMapper = $authorMapper;
        parrent::__construct($adapter);
    }

    /*Get Author Mapper*/
    public function getAuthorMapper()
    {
        return $this->authorMapper;
    }

    /*Create a comment entity with the suppllied data*/
    public function createEntity(array $data)
    {
        $comments = new $this->entityClass(array( 
            "id" => $data['id'],
            "content" => $data['content'],
            'author' => new ProxyEnity[$this->authorMapper, $data['author_id']],
        ));

        return $comment;
    }
}