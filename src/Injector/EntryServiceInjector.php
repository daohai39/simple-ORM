<?php

namespace App\Injector;

use BlogLibraryDatabase;
use BlogModelMapper;
use BlogService;

class EntryServiceInjector implements InjectorInterface 
{
    /*Create the entry service*/
    public function create()
    {
        $mysqlInjector = new MysqlAdapterInjector;
        $mysqlAdapter = $mysqlInjector->create();
        return new ServiceEntryService(
            new MapperEntryMapper(
                $mysqlAdapter, new MapperCommentMapper(
                    $mysqlAdapter, new MapperAuthorMapper($mysqlAdapter)
                )
            )
        );
    }
}