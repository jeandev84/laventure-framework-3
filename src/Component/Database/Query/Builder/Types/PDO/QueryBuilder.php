<?php
namespace Laventure\Component\Database\Query\Builder\Types\PDO;


use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\Types\QueryBuilderContract;



/**
 * @class QueryBuilder
 *
 * @package Laventure\Component\Database\Query\Builder\Types\PDO
 *
 * @author
*/
class QueryBuilder extends QueryBuilderContract
{


      /**
       * @param PdoConnection $connection
       * @param string $table
      */
      public function __construct(PdoConnection $connection, string $table)
      {
             parent::__construct($connection, $table);
      }






      /**
       * @param array $arguments
       * @return array
      */
      protected function resolveInsertions(array $arguments): array
      {
          $resolved = [];

          foreach ($arguments as $index => $credentials) {
               foreach (array_keys($credentials) as $column) {
                    $resolved[$index][$column] = ":{$column}";
               }
          }

          return $resolved;
      }





      /**
       * @inheritdoc
      */
      protected function resolveWheres(array $wheres): array
      {
           $bindings = [];

           foreach ($wheres as $column) {
              $bindings[] = "$column = :{$column}";
           }

           return $bindings;
      }





     /**
      * @param array $attributes
      * @return array
     */
     protected function resolveAttributes(array $attributes): array
     {
         $resolved = [];
         foreach (array_keys($attributes) as $column) {
             $resolved[$column] = ":{$column}";
         }
         return $resolved;
     }
}