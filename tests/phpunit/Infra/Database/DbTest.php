<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database;

use \Infra\Database\Db;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class DbTest extends TestCase
{
    public function testCantConnectWithoutConnexionQuery() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Env var DATABASE_CONNEXION_QUERY must be set');

        Db::connect();
    }

    public function testCantConnectWithoutDbName() : void
    {
        \putenv('DATABASE_CONNEXION_QUERY=this-is-a-connexion-query');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Env var DATABASE_DB_NAME must be set');

        Db::connect();
    }

    public function testCantConnectWithoutPassword() : void
    {
        \putenv('DATABASE_CONNEXION_QUERY=this-is-a-connexion-query');
        \putenv('DATABASE_DB_NAME=this-is-a-database-name');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Env var DATABASE_PASSWORD must be set');

        Db::connect();
    }

    public function testCanConnect() : void
    {
        \putenv('DATABASE_CONNEXION_QUERY=sqlite:tests/resources/db/file.db');
        \putenv('DATABASE_DB_NAME=this-is-a-database-name');
        \putenv('DATABASE_PASSWORD=a-very-secure-password-that-nobody-will-ever-know');

        Db::connect();

        $this->assertTrue(R::testConnection());

        Db::disconnect();
    }

    protected function setUp() : void
    {
        parent::setUp();

        // Remove previously set env vars
        \putenv('DATABASE_CONNEXION_QUERY');
        \putenv('DATABASE_DB_NAME');
        \putenv('DATABASE_PASSWORD');
    }
}
