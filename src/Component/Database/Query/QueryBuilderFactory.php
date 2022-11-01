<?php
namespace Laventure\Component\Database\Query;



use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionType;
use Laventure\Component\Database\Query\Builder\Extension\Builder;
use Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilderPdo;


/**
 *
*/
class QueryBuilderFactory
{

      /**
       * @param ConnectionInterface $connection
       * @return Builder
     */
     public static function make(ConnectionInterface $connection): Builder
     {
          return [
              ConnectionType::PDO => new QueryBuilderPdo($connection)
          ][$connection->getTypeName()];
     }
}