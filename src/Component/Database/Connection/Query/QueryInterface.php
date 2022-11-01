<?php
namespace Laventure\Component\Database\Connection\Query;


/**
 * QueryInterface
*/
interface QueryInterface
{

     /**
      * @param $sql
      * @return $this
     */
     public function prepare($sql): QueryInterface;




     /**
      * @param array $params
      * @return $this
     */
     public function params(array $params): QueryInterface;




     /**
      * Map class name to fetch
      *
      * @param $class
      * @return $this
     */
     public function map($class): QueryInterface;




     /**
      * @return bool
     */
     public function execute(): bool;




     /**
      * Execute statement
      *
      * @param $sql
      * @return bool
     */
     public function exec($sql): bool;




     /**
      * Begin transaction
      *
      * @return mixed
     */
     public function beginTransaction();




     /**
      * Commit
      *
      * @return mixed
     */
     public function commit();




     /**
      * Rollback
      *
      * @return mixed
     */
     public function rollback();




     /**
      * @return QueryHydrateInterface
     */
     public function fetch(): QueryHydrateInterface;




     /**
      * Fetch all records
      *
      * @return mixed
     */
     public function fetchAll();





     /**
      * Fetch one record
      *
      * @return mixed
     */
     public function fetchOne();





     /**
      * Fetch columns
      *
      * @return mixed
     */
     public function fetchColumns();




     /**
      * @return mixed
     */
     public function rowCount();





     /**
      * @return mixed
     */
     public function errors();




     /**
      * Get last insert id
      *
      * @param $name
      * @return int
     */
     public function lastId($name = null): int;




     /**
      * @return mixed
     */
     public function getQueryLog();
}