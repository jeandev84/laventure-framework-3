<?php
namespace Laventure\Component\Database\Query\Builder\Types\PDO;


use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\Types\QueryBuilderContract;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;



/**
 * @class PdoQueryBuilder
 *
 * @package Laventure\Component\Database\Query\Builder\Types\PDO
 *
 * @author
*/
class PdoQueryBuilder extends QueryBuilderContract
{


      /**
       * @var int
      */
      protected $attributeInc = 1;





      /**
       * @var int
      */
      protected $parameterInc = 1;





      /**
       * @var array
      */
      protected $parameters = [];






      /**
       * @param PdoConnection $connection
       * @param $table
      */
      public function __construct(PdoConnection $connection, $table)
      {
            parent::__construct($connection, $table);
      }




      /**
       * @inheritdoc
      */
      protected function resolveWheres(SqlBuilder $builder)
      {
           if (! empty($this->wheres)) {

               foreach ($this->whereColumns() as $column) {
                   $builder->where("$column = :{$column}");
               }

               $builder->setParameters($this->wheres);
           }

           return $builder;
      }





      /**
       * @param array $attributes
       * @return Insert
      */
      public function inserts(array $attributes): Insert
      {
            $insert = new Insert($this->getTable());

            foreach ($attributes as $arguments) {

                 $insert->add($this->resolveAttributes($arguments));
                 $insert->setParameters($this->resolveParameters($arguments));
            }

            /* dump($insert->getSQL()); */

            return $insert;
      }





      /**
       * @param array $attributes
       * @return Update
      */
      public function update(array $attributes): Update
      {
           $command =  parent::update($attributes);

           $command->setParameters($this->resolveParameters($attributes));

          /* dump($insert->getSQL()); */

           return $command;
      }






     /**
       * Return where columns
       *
       * @return array
      */
      protected function whereColumns(): array
      {
           return array_keys($this->wheres);
      }





      /**
       * @param array $attributes
       * @return array
      */
      protected function resolveAttributes(array $attributes): array
      {
           $resolved = [];

           foreach (array_keys($attributes) as $column) {
               $resolved[$column] = ":{$column}{$this->attributeInc}";
           }

           $this->attributeInc++;

           return $resolved;
      }







      /**
       * @param array $attributes
       * @return array
      */
      protected function resolveParameters(array $attributes): array
      {
          $resolved = [];

          foreach ($attributes as $column => $value) {
              $resolved["{$column}{$this->parameterInc}"] = $value;
          }

          $this->parameterInc++;

          return $resolved;
      }




      /**
       * @return void
      */
      protected function resetIndex()
      {
           $this->index = 1;
      }
}