<?php
namespace Laventure\Component\Database\Query\Builder\SQL;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;


/**
 * @class SqlBuilderFactory
 *
 * @package Laventure\Component\Database\Query\Builder\SQL
*/
class SqlBuilderFactory
{

     /**
      * @var ConnectionInterface
     */
     protected $connection;





     /**
      * @param ConnectionInterface $connection
     */
     public function __construct(ConnectionInterface $connection)
     {
           $this->connection = $connection;
     }





     /**
      * @return Select
      * @param $table
     */
     public function createSelectQuery($table): Select
     {
          return new Select($this->connection, $table);
     }




     /**
      * @return Insert
      * @param $table
     */
     public function createInsertQuery($table): Insert
     {
          return new Insert($this->connection, $table);
     }






     /**
      * @return Update
      * @param $table
     */
     public function createUpdateQuery($table): Update
     {
          return new Update($this->connection, $table);
     }





     /**
      * @return Delete
      * @param $table
     */
     public function createDeleteQuery($table): Delete
     {
          return new Delete($this->connection, $table);
     }
}