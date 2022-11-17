<?php
namespace Laventure\Component\Database\Query\Builder\SQL;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\Contract\SqlQueryBuilderInterface;


/**
 * @class SqlQueryBuilder
 *
 * @package Laventure\Component\Database\Query\Builder\SQL
 *
 * @author
*/
class SqlQueryBuilder implements SqlQueryBuilderInterface
{

       /**
        * @var ConnectionInterface
       */
       protected $connection;




       /**
        * @var SqlBuilderFactory
       */
       protected $factory;





       /**
        * SqlQueryBuilder construct.
        *
        * @param ConnectionInterface $connection
       */
       public function __construct(ConnectionInterface $connection)
       {
              $this->connection = $connection;
              $this->factory    = new SqlBuilderFactory($connection);
       }





       /**
        * @return ConnectionInterface
       */
       public function getConnection(): ConnectionInterface
       {
             return $this->connection;
       }





       /**
        * @return SqlBuilderFactory
       */
       public function getFactory(): SqlBuilderFactory
       {
            return $this->factory;
       }




       /**
        * @param array $selects
        * @param string $table
        * @return Select
       */
       public function select(array $selects, string $table): Select
       {
            $command = $this->factory->createSelectQuery($table);
            $command->addSelect($selects);
            return $command;
       }







       /**
        * @param array $attributes
        * @param string $table
        * @return Insert
       */
       public function insert(array $attributes, string $table): Insert
       {
            $command = $this->factory->createInsertQuery($table);
            $command->columns($attributes);
            $command->data($attributes);
            return $command;
       }








       /**
        * @param array $attributes
        * @param string $table
        * @return Update
       */
       public function update(array $attributes, string $table): Update
       {
             $command = $this->factory->createUpdateQuery($table);

             foreach ($attributes as $column => $value) {
                  $command->set($column, $value);
             }

             return $command;
       }






      /**
       * @param $table
       * @return Delete
      */
      public function delete($table): Delete
      {
           return $this->factory->createDeleteQuery($table);
      }

}