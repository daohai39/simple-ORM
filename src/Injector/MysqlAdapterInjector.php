<?php

namespace App\Injector;

use BlogLibraryDatabase;

class MysqlAdapterInjector implements InjectorInterface
{
    protected static $mysqlAdapter;

    /*Create an instance of the MySQLAdapter class*/
    public function create()
    {
        if(self::$mysqlAdapter === null) {
            self:::$mysqlAdapter = new DatabaseMysqlAdapter(array(
                'localhost',
                'root',
                'Haidao3c!@#',
                'simple_ORM',
            ));
        }
        return self::$mysqlAdapter;
    }
}