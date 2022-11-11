<?php
namespace Laventure\Component\Database\Query\Builder\Types;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\Builder;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 * @class QueryBuilderContract
 *
 * @package Laventure\Component\Database\Query\Builder\Types
 *
 * @author
*/
abstract class QueryBuilderContract
{



        /**
         * @var Builder
        */
        protected $builder;





        /**
         * @var array
        */
        protected $wheres = [];






        /**
         * QueryBuilderContract constructor.
         *
         * @param ConnectionInterface $connection
         * @param $table
        */
        public function __construct(ConnectionInterface $connection, $table)
        {
              $this->builder = new Builder($connection, $table);
        }






        /**
         * @return string
        */
        public function getTable(): string
        {
             return $this->builder->getTable();
        }






        /**
         * @param array $wheres
         * @return $this
        */
        public function wheres(array $wheres): self
        {
              $this->wheres = $wheres;

              return $this;
        }






        /**
         * @param array $selects
         *
         * @return Select
        */
        public function select(array $selects): Select
        {
             return $this->resolveWheres($this->builder->select($selects));
        }


        
        
        
        
        /**
         * @param array $attributes
         * @return Insert
        */
        public function insert(array $attributes): Insert
        {
              $this->wheres = [];

              if (! empty($attributes[0])) {
                   return $this->insertMultiple($attributes);
              }


              return $this->builder->insert($this->resolveAttributes($attributes));
        }






        /**
         * @param array $attributes
         * @return Insert
        */
        public function insertMultiple(array $attributes): Insert
        {
              $insert = new Insert($this->getTable());

              foreach ($attributes as $attribute) {
                   $insert->add($this->resolveAttributes($attribute));
              }

              return $insert;
        }




        
        
        /**
         * @param array $attributes
         * @return Update
        */
        public function update(array $attributes): Update
        {
             $attributes = $this->resolveAttributes($attributes);

             return $this->resolveWheres($this->builder->update($attributes));
        }







        /**
         * @return Delete
        */
        public function delete(): Delete
        {
             return $this->resolveWheres($this->builder->delete());
        }






        /**
         * Resolve criteria
         *
         * @param SqlBuilder $builder
         * @return mixed
        */
        abstract protected function resolveWheres(SqlBuilder $builder);







        /**
         * Resolve insertion attributes
         *
         * @param array $attributes
         * @return array
        */
        protected function resolveAttributes(array $attributes): array
        {
              $resolved = [];

              foreach ($attributes as $column => $value) {
                 $resolved[$column] = "'{$value}'";
              }

              return $resolved;
        }
}