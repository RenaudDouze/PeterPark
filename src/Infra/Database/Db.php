<?php

declare(strict_types = 1);

namespace Infra\Database;

use \RedBeanPHP\R;

class Db
{
    public const DB_KEY = 'app-db';

    public static function connect() : void
    {
        $connectionQuery = \getenv('DATABASE_CONNEXION_QUERY');
        $dbName = \getenv('DATABASE_DB_NAME');
        $password = \getenv('DATABASE_PASSWORD');

        if ($connectionQuery === false) {
            throw new \InvalidArgumentException('Env var DATABASE_CONNEXION_QUERY must be set');
        }

        if ($dbName === false) {
            throw new \InvalidArgumentException('Env var DATABASE_DB_NAME must be set');
        }

        if ($password === false) {
            throw new \InvalidArgumentException('Env var DATABASE_PASSWORD must be set');
        }

        if (! R::hasDatabase(self::DB_KEY)) {
            R::addDatabase(self::DB_KEY, $connectionQuery, $dbName, $password);
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
