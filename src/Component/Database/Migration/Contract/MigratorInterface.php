<?php
namespace Laventure\Component\Database\Migration\Contract;


/**
 *
*/
interface MigratorInterface
{

     /**
      * Create migration table
      *
      * @return mixed
     */
     public function install();




     /**
      * Create all schema tables
      *
      * @return mixed
     */
     public function migrate();





     /**
      * Drop all schema tables
      *
      * @return mixed
     */
     public function rollback();





     /**
      * Drop all schema tables and version table.
      *
      * @return mixed
     */
     public function reset();




     /**
      * Reset migrations and delete all migration files
      *
      * @return mixed
     */
     public function clear();





     /**
      * Get migration collection
      *
      * @return mixed
     */
     public function getMigrations();




     /**
      * Get migrations to apply
      *
      * @return mixed
     */
     public function getMigrationsToApply();






    /**
     * Get applied migrations
     *
     * @return mixed
     */
    public function getAppliedMigrations();
}