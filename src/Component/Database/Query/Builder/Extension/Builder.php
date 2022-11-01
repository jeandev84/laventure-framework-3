<?php
namespace Laventure\Component\Database\Query\Builder\Extension;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\SqlQueryBuilder;



/**
 * Builder
*/
abstract class Builder extends SqlQueryBuilder
{


      /**
       * @var string
      */
      protected $table;




      /**
       * @var array
      */
      protected $wheres = [];




      /**
       * @param ConnectionInterface $connection
      */
      public function __construct(ConnectionInterface $connection)
      {
             parent::__construct($connection);
      }





      /**
       * @param string $table
       * @return void
      */
      public function table(string $table)
      {
           $this->table = $table;
      }




      /**
       * @return string
      */
      public function getTable(): string
      {
           return $this->table;
      }




      /**
       * Add where conditions
       *
       * @param array $wheres
       * @return $this
      */
      public function criteria(array $wheres): self
      {
           $this->wheres = $wheres;

           return $this;
      }




      /**
       * @param array $selects
       * @return Select
      */
      public function select(array $selects = ["*"]): Select
      {
           return parent::selectQuery($selects, $this->getTable());
      }






      /**
       * @param array $attributes
       * @return Insert
      */
      public function insert(array $attributes): Insert
      {
          return parent::insertQuery($attributes, $this->getTable());
      }





      /**
       * @param array $attributes
       * @return Update
      */
      public function update(array $attributes): Update
      {
            return parent::updateQuery($attributes, $this->getTable());
      }





      /**
       * @return Delete
      */
      public function delete(): Delete
      {
           return parent::deleteQuery($this->getTable());
      }




     /**
      * @param SqlBuilder $builder
      * @return SqlBuilder|mixed|null
     */
     public function resolveCommandSQL(SqlBuilder $builder)
     {
         $builder = parent::resolveCommandSQL($builder);

         if (! empty($this->wheres)) {
            $builder = $this->resolveWheres($builder);
         }

         return $builder;
     }




      /**
       * @param SqlBuilder $builder
       * @return void
      */
      abstract protected function resolveWheres(SqlBuilder $builder): SqlBuilder;

}