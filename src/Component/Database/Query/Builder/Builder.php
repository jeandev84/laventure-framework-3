<?php
namespace Laventure\Component\Database\Query\Builder;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlQueryBuilder;


/**
 * @class Builder
 *
 * @package Laventure\Component\Database\Query\Builder
 *
 * @author
*/
class Builder
{


      /**
       * @var string
      */
      protected $table;






      /**
       * @var SqlQueryBuilder
      */
      protected $builder;





      /**
       * @param ConnectionInterface $connection
       * @param string $table
      */
      public function __construct(ConnectionInterface $connection, string $table)
      {
             $this->builder = new SqlQueryBuilder($connection);
             $this->table   = $table;
      }






      /**
       * Return table name
       *
       * @return string
      */
      public function getTable(): string
      {
           return $this->table;
      }






      /**
       * @param array $selects
       * @return Select
      */
      public function select(array $selects): Select
      {
            return $this->builder->select($selects, $this->getTable());
      }






      /**
       * @param array $attributes
       * @return Insert
      */
      public function insert(array $attributes): Insert
      {
           return $this->builder->insert($attributes, $this->getTable());
      }






      /**
       * @param array $attributes
       * @return Update
      */
      public function update(array $attributes): Update
      {
            return $this->builder->update($attributes, $this->getTable());
      }





      /**
       * @return Delete
      */
      public function delete(): Delete
      {
           return $this->builder->delete($this->getTable());
      }
}