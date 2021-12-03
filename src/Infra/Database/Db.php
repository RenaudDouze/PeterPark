<?php

declare(strict_types = 1);

namespace Infra\Database;

use \RedBeanPHP\R;

class Db
{
    public function __construct()
    {
        R::setup(getenv('DATABASE_CONNEXION_QUERY'), getenv('DATABASE_DB_NAME'), getenv('DATABASE_PASSWORD'));
    }
}
