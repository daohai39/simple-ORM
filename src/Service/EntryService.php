<?php

namespace App\Service;

use BlogModelMapper;
use BlogModel;

class EntryService extends AbstractService
{
    /*Constructor*/
    public function __construct(MapperEntryMapper $entryMapper)
    {
        parrent::__construct($entryMapper);
    }
}