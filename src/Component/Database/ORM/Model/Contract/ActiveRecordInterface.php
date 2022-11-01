<?php
namespace Laventure\Component\Database\ORM\Model\Contract;


/**
 *
*/
interface ActiveRecordInterface
{

     /**
      * Get primary key name
      *
      * @return string
     */
     public function primaryKey(): string;



//     /**
//      * Get Table name
//      *
//      * @return string
//     */
//     public function getTable(): string;





     /**
      * Get last inserted ID
      *
      * @return int
     */
     public function lastId(): int;




     /**
      * @param $id
      * @return mixed
     */
     public function findOne($id);




     /**
      * Find all records from table
      *
      * @return mixed
     */
     public function findAll();




     /**
      * Create a new record.
      *
      * @param array $attributes
      * @return mixed
     */
     public function insert(array $attributes);




     /**
      * Update one record by primary key
      *
      * @param array $attributes
      * @param $id
      * @return mixed
     */
     public function update(array $attributes, $id);





     /**
      * @param $id
      * @return mixed
     */
     public function delete($id);
}