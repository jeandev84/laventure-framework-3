<?php
namespace Laventure\Component\Database\Connection\Types\PDO\Drivers;

use Laventure\Component\Database\Connection\Types\DriverType;
use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;


class OracleConnection extends PdoConnection
{

     /**
      * @return string
     */
     public function getName(): string
     {
         return DriverType::ORACLE;
     }



    /**
     * @return mixed|void
     */
    public function createDatabase(): bool
    {

    }



    /**
     * @return mixed|void
     */
    public function dropDatabase(): bool
    {
        // TODO: Implement dropDatabase() method.
    }
}