<?php
namespace Laventure\Component\Database\Schema\BluePrint;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Types\DriverType;
use Laventure\Component\Database\Schema\BluePrint\Types\MysqlBluePrint;
use Laventure\Component\Database\Schema\BluePrint\Types\PgsqlBluePrint;

/**
 * BluePrintFactory
*/
class BluePrintFactory
{
     /**
       * @param ConnectionInterface $connection
       * @param $table
       * @return BluePrint
     */
     public static function create(ConnectionInterface $connection, $table): BluePrint
     {
         return [
               DriverType::MYSQL => new MysqlBluePrint($connection, $table),
               DriverType::PGSQL => new PgsqlBluePrint($connection, $table)
           ][$connection->getName()];
     }
}