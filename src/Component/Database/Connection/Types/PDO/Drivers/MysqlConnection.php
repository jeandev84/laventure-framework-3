<?php
namespace Laventure\Component\Database\Connection\Types\PDO\Drivers;

use Laventure\Component\Database\Connection\Types\DriverType;
use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;


/**
 *
*/
class MysqlConnection extends PdoConnection
{

    /**
     * @return string
    */
    public function getName(): string
    {
        return DriverType::MYSQL;
    }




    /**
     * @inheritdoc
    */
    public function createDatabase(): bool
    {
        $database = $this->config->getDatabase();

        $this->exec("CREATE DATABASE IF NOT EXISTS {$database};");

        return in_array($database, $this->showDatabases());
    }





    /**
     * @inheritdoc
    */
    public function dropDatabase(): bool
    {
         $database = $this->config->getDatabase();

         $this->exec("DROP DATABASE IF EXISTS {$database};");

         return ! in_array($database, $this->showDatabases());
    }




    /**
     * @inheritdoc
    */
    public function showDatabases(): array
    {
        return $this->statement('SHOW DATABASES')
                    ->fetch()
                    ->columns();
    }




    /**
     * @inheritDoc
    */
    public function showTables(): array
    {
        return $this->statement("SHOW FULL TABLES FROM {$this->getDatabase()};")
                    ->fetch()
                    ->columns();

    }
}