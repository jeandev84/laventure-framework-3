<?php
namespace Laventure\Component\Database\Query;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\Extension\Builder;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;


/**
 *
*/
class QueryBuilder
{


      /**
       * @var Builder
      */
      protected $builder;




      /**
        * @param ConnectionInterface $connection
        * @param string|null $table
      */
      public function __construct(ConnectionInterface $connection, string $table = null)
      {
             $this->builder = QueryBuilderFactory::make($connection);

             if ($table) {
                  $this->builder->table($table);
             }
      }




      /**
       * @param Builder $builder
       * @return $this
      */
      public function with(Builder $builder): QueryBuilder
      {
           $this->builder = $builder;

           return $this;
      }




      /**
       * @param array $wheres
       * @return $this
      */
      public function criteria(array $wheres): self
      {
           $this->builder->criteria($wheres);

           return $this;
      }




      /**
       * @param string $table
       * @return $this
      */
      public function table(string $table): self
      {
           $this->builder->table($table);

           return $this;
      }




      /**
       * @return string
      */
      public function getTable(): string
      {
           return $this->builder->getTable();
      }



      /**
       * @param string $class
       * @return void
      */
      public function classMap(string $class)
      {
           $this->builder->mapClass($class);
      }



      /**
       * @param array $selects
       * @return Select
      */
      public function select(array $selects = ["*"]): Select
      {
           return $this->builder->select($selects);
      }




      /**
       * Return lastId if record successfully create
       * OR false if insertion failed.
       *
       * @param array $attributes
       * @return false|int
      */
      public function insert(array $attributes)
      {
           $query = $this->builder->insert($attributes);

           if (! $query->execute()) {
               return false;
           }

           return $query->lastId();
      }



      /**
       * @param array $attributes
       * @param array $wheres
       * @return Update
      */
      public function update(array $attributes, array $wheres = []): Update
      {
            $this->criteria($wheres);

            return $this->builder->update($attributes);
      }


      /**
       * @param array $wheres
       * @return Delete
      */
      public function delete(array $wheres = []): Delete
      {
           $this->criteria($wheres);

           return $this->builder->delete();
      }
}