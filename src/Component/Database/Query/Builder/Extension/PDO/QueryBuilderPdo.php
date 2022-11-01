<?php
namespace Laventure\Component\Database\Query\Builder\Extension\PDO;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;
use Laventure\Component\Database\Query\Builder\Extension\PDO\SQL\Commands\DeleteBuilderPdo;
use Laventure\Component\Database\Query\Builder\Extension\PDO\SQL\Commands\InsertBuilderPdo;
use Laventure\Component\Database\Query\Builder\Extension\PDO\SQL\Commands\SelectBuilderPdo;
use Laventure\Component\Database\Query\Builder\Extension\PDO\SQL\Commands\UpdateBuilderPdo;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\Extension\Builder;



/**
 * QueryBuilderPdo
*/
class QueryBuilderPdo extends Builder
{

       /**
        * @param PdoConnection|ConnectionInterface $connection
       */
       public function __construct(PdoConnection $connection)
       {
              parent::__construct($connection);
       }




       /**
        * @param array $selects
        * @return Select
       */
       public function select(array $selects = ["*"]): Select
       {
            return $this->resolveCommandSQL(
                new SelectBuilderPdo($selects, $this->getTable())
            );
       }




       /**
        * @param array $attributes
        * @return Insert
       */
       public function insert(array $attributes): Insert
       {
           return $this->resolveCommandSQL(
               new InsertBuilderPdo($attributes, $this->getTable())
           );
       }




       /**
        * @param array $attributes
        * @return Update
       */
       public function update(array $attributes): Update
       {
             return $this->resolveCommandSQL(
                 new UpdateBuilderPdo($attributes, $this->getTable())
             );
       }




       /**
        * @return Delete
       */
       public function delete(): Delete
       {
             return $this->resolveCommandSQL(
                 new DeleteBuilderPdo($this->getTable())
             );
       }




       /**
        * @param SqlBuilder $builder
        * @return SqlBuilder
       */
       protected function resolveWheres(SqlBuilder $builder): SqlBuilder
       {
            foreach ($this->wheres as $column => $value) {
                $builder->andWhere("$column = :$column");
                $builder->setParameter($column, $value);
            }

            return $builder;
       }
}