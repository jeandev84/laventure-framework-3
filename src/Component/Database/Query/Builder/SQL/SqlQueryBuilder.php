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
        * SqlQueryBuilder construct.
        *
        * @param ConnectionInterface $connection
       */
       public function __construct(ConnectionInterface $connection)
       {
              $this->connection = $connection;
       }






       /**
        * @param array $selects
        * @param string $table
        * @return Select
       */
       public function select(array $selects, string $table): Select
       {
            return $this->connect(new Select($selects, $table));
       }







       /**
        * @param array $attributes
        * @param string $table
        * @return Insert
       */
       public function insert(array $attributes, string $table): Insert
       {
            $insert = new Insert($table);
            $insert->add($attributes);
            return $this->connect($insert);
       }








       /**
        * @param array $attributes
        * @param string $table
        * @return Update
       */
       public function update(array $attributes, string $table): Update
       {
             $update = new Update($table);

             foreach ($attributes as $column => $value) {
                  $update->set($column, $value);
             }

             return $this->connect($update);
       }






      /**
       * @param $table
       * @return Delete
      */
      public function delete($table): Delete
      {
           return $this->connect(new Delete($table));
      }





      /**
       * @param SqlBuilder $command
       * @return mixed
      */
      public function connect(SqlBuilder $command)
      {
           $command->connection($this->connection);

           return $command;
      }
}