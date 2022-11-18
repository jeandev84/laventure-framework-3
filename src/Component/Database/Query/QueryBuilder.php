<?php
namespace Laventure\Component\Database\Query;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\Types\QueryBuilderContract;


/**
 * @class QueryBuilder
 *
 * @package Laventure\Component\Database\Query
 *
 * @author
*/
class QueryBuilder
{



       /**
        * @var QueryBuilderContract
       */
       protected $query;






       /**
        * QueryBuilder constructor .
        *
        * @param ConnectionInterface $connection
        * @param string $table
       */
       public function __construct(ConnectionInterface $connection, string $table)
       {
             $this->query  = QueryBuilderFactory::make($connection, $table);
       }






       /**
        * Resolve Command SQL
        *
        * @param SqlBuilder $builder
        * @return mixed
       */
       public function resolve(SqlBuilder $builder)
       {
            return $this->query->resolve($builder);
       }






       /**
        * Return Select SQL Builder
        *
        * @param array $columns
        * @param array $criteria
        * @return Select
       */
       public function select(array $columns = ["*"], array $criteria = []): Select
       {
            return $this->query->select($columns, $criteria);
       }






       /**
        * Return Insert SQL Builder
        *
        * @param array $attributes
        * @return false|int
       */
       public function insert(array $attributes)
       {
            return $this->query->insert($attributes);
       }






       /**
        * Return Update SQL Builder
        *
        * @param array $attributes
        * @param array $criteria
        * @return Update
       */
       public function update(array $attributes, array $criteria): Update
       {
            return $this->query->update($attributes, $criteria);
       }





       /**
        * Return Delete SQL Builder
        *
        * @param array $criteria
        * @return Delete
       */
       public function delete(array $criteria): Delete
       {
            return $this->query->delete($criteria);
       }
}