<?php

declare(strict_types = 1);

namespace Tests\Tools\Infra\Database;

use \RedBeanPHP\R;

class Db
{
    public const DB_KEY = 'unit-testing-db';

    public static function connect() : void
    {
        if (! R::hasDatabase(self::DB_KEY)) {
            R::addDatabase(self::DB_KEY, 'sqlite:tests/resources/db/test.db');
        }

        R::selectDatabase(self::DB_KEY);
    }

    public static function disconnect() : void
    {
        if (! R::hasDatabase(self::DB_KEY)) {
            return;
        }

        R::selectDatabase(self::DB_KEY);
        R::close();
    }

    public static function select() : bool
    {
        if (! R::hasDatabase(self::DB_KEY)) {
            return false;
        }

        R::selectDatabase(self::DB_KEY);

        return true;
    }
}
