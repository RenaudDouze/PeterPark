<?php

declare(strict_types = 1);

namespace Infra\Database;

use \RedBeanPHP\R;

class Db
{
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

        R::setup($connectionQuery, $dbName, $password);
    }
}
