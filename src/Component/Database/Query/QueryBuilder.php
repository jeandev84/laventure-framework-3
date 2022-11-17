<?php
namespace Laventure\Component\Database\Query;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\Builder;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\Types\BaseQueryBuilder;
use Laventure\Component\Database\Query\Resolver\QueryResolver;



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
        * @var Builder
       */
       protected $builder;






       /**
        * QueryBuilder constructor .
        *
        * @param ConnectionInterface $connection
        * @param string $table
       */
       public function __construct(ConnectionInterface $connection, string $table)
       {
             $this->builder  = QueryBuilderFactory::make($connection, $table);
       }




       /**
        * Return Select SQL Builder
        *
        * @param array $selects
        * @return Select
       */
       public function select(array $selects = ["*"]): Select
       {
            return $this->builder->select($selects);
       }





       /**
        * Return Insert SQL Builder
        *
        * @param array $attributes
        * @return Insert
       */
       public function insert(array $attributes): Insert
       {
            return $this->builder->insert($attributes);
       }






       /**
        * Return Update SQL Builder
        *
        * @param array $attributes
        * @return Update
       */
       public function update(array $attributes): Update
       {
            return $this->builder->update($attributes);
       }






       /**
        * Return Delete SQL Builder
        *
        * @return Delete
       */
       public function delete(): Delete
       {
            return $this->builder->delete();
       }
}