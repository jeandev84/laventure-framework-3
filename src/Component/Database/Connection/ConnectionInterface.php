<?php
namespace Laventure\Component\Database\Connection;


use Closure;
use Laventure\Component\Database\Connection\Configuration\ConfigurationBagInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Traversable;


/**
 *
*/
interface ConnectionInterface
{


     /**
      * Get connection type name
      *
      * @return string
     */
     public function getTypeName(): string;



     /**
      * Get connection name
      *
      * @return string
     */
     public function getName(): string;




     /**
      * Connect to the database
      *
      * @param array|Traversable $credentials
      * @return mixed
     */
     public function connect($credentials);




     /**
      * Determine if the connection established
      *
      * @return bool
     */
     public function connected(): bool;






     /**
      * Reconnection to the database
      *
      * @return mixed
     */
     public function reconnect();





     /**
      * Disconnect to the database
      *
      * @return mixed
     */
     public function disconnect();





     /**
      * Determine if connection must be to reconnect
      *
      * @return bool
     */
     public function reconnected(): bool;






     /**
      * Make a query statement
      *
      * @param $sql
      * @param array $params
      * @return QueryInterface
     */
     public function statement($sql, array $params = []): QueryInterface;





     /**
      * Get configuration parameter
      *
      * @param $name
      * @return ConfigurationBagInterface|mixed
     */
     public function config($name = null);





     /**
      * Begin a transaction query
      *
      * @return mixed
     */
     public function beginTransaction();




     /**
      * Commit transaction
      *
      * @return mixed
     */
     public function commit();





     /**
      * Rollback transaction
      *
      * @return mixed
     */
     public function rollback();





     /**
      * Execute multi queries
      *
      * @param Closure $statements
      * @return mixed
     */
     public function transaction(Closure $statements);




     /**
      * Get last insert id
      *
      * @param $name
      * @return int
     */
     public function lastInsertId($name = null): int;




     /**
      * Execute query
      *
      * @param $sql
      * @return boolean
     */
     public function exec($sql): bool;





     /**
      * Get connection
      *
      * @return mixed
     */
     public function getConnection();




     /**
      * Get database name
      *
      * @return mixed
     */
     public function getDatabase();




     /**
      * Get query logs
      *
      * @return string[]
     */
     public function getQueryLog(): array;




     /**
      * Create database
      *
      * @return bool
     */
     public function createDatabase(): bool;




     /**
      * Drop database
      *
      * @return bool
     */
     public function dropDatabase(): bool;




     /**
      * Show databases
      *
      * @return array
     */
     public function showDatabases(): array;



     /**
      * Show all tables
      *
      * @return array
     */
     public function showTables(): array;





     /**
      * Prepare database table name
      *
      * @return mixed
     */
     public function prepareTable($table);
}