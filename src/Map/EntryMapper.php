<?php

namespace App\Map;

use BlogLibraryDatabase;
use BlogModelProxy;
use App\Database\DatabaseAdapterInterface;

class EntryMapper extends AbstractMapper
{
    protected $commentMapper;
    protected $entityTable = "entries";
    protected $entityClass = "BlogModelEntry";

    /*Constructor*/
    public function __construct(DatabaseAdapterInterface $adapter, CommentMapper $commentMapper)
    {
        $this->commentMapper = $commentMapper;
        parent::__construct($adapter);
    }

    /*Get the comment mapper*/
    public function getCommentMapper()
    {
        return $this->commentMapper;
    }

    /*Delete an entry from the storage*/
    public function delete($id, $col = 'id')
    {
        parent::delete($id);
        return $this->commentMapper->delete($id,"entry_id");
    }

    /*
     * Create an entry entity with the supplied data
     * (assigns a collection proxy to the ‘comments’ field for lazy-loading comments)
     */
    public function createEntity(array $data)
    {
        $entry = new $this->entityClass(array(
            'id' => $data['id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'comments' => new ProxyCollection($this->commentMapper, "entry_id = {$data['id']}");
        ));
        return $entry;
    }

    
}