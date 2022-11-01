<?php
namespace Laventure\Component\Database\Connection;


use Laventure\Component\Database\Connection\Types\DriverType;
use Laventure\Component\Database\Connection\Types\PDO\Drivers\MysqlConnection;
use Laventure\Component\Database\Connection\Types\PDO\Drivers\OracleConnection;
use Laventure\Component\Database\Connection\Types\PDO\Drivers\PgsqlConnection;
use Laventure\Component\Database\Connection\Types\PDO\Drivers\SqliteConnection;

/**
 * ConnectionStack
*/
class ConnectionStack
{

     /**
      * @return array
     */
     public static function getDefaultConnections(): array
     {
          return [
              new MysqlConnection(),
              new PgsqlConnection(),
              new SqliteConnection(),
              new OracleConnection()
          ];
     }
}