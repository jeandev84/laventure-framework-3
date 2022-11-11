<?php
namespace Laventure\Component\Database\Query;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionType;
use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;
use Laventure\Component\Database\Query\Builder\Types\PDO\PdoQueryBuilder;
use Laventure\Component\Database\Query\Builder\Types\QueryBuilderContract;

/**
 *
*/
class QueryBuilderFactory
{

     /**
      * @param $connection
      * @param $table
      * @return QueryBuilderContract|null
     */
     public static function make($connection, $table): ?QueryBuilderContract
     {
          return [
              ConnectionType::PDO => new PdoQueryBuilder($connection, $table)
          ][$connection->getTypeName()] ?: null;
     }
}