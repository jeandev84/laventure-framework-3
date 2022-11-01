<?php
namespace Laventure\Component\Database\Migration\Collection;


use Laventure\Component\Database\Migration\Migration;

/**
 * MigrationCollection
*/
class MigrationCollection
{

       /**
        * Collect migrations
        *
        * @var array
       */
       protected $migrations  = [];




       /**
        * Store the migration file path by migration name.
        *
        * @var array
       */
       protected $paths = [];




       /**
        * @param Migration $migration
        * @return $this
       */
       public function add(Migration $migration): self
       {
             $name = $migration->getName();

             $this->migrations[$name] = $migration;
             $this->paths[$name]      = $migration->getPath();
             
             return $this;
       }


       
       
       
       /**
        * @param array $migrations
        * @return void
       */
       public function merge(array $migrations)
       {
           foreach ($migrations as $migration) {
               $this->add($migration);
           }
       }





       /**
        * Get migrations to execute
        *
        * @param string[] $oldMigrations
        * @return array
       */
       public function diff(array $oldMigrations): array
       {
             $newMigrations = [];

             foreach ($this->getMigrations() as $migration) {
                   if (! in_array($migration->getName(), $oldMigrations)) {
                         $newMigrations[] = $migration;
                   }
             }

             return $newMigrations;
       }




       
       /**
        * @return Migration[]
       */
       public function getMigrations(): array
       {
            return $this->migrations;
       }



       /**
        * @param $name
        * @return void
       */
       public function removeMigration($name)
       {
            if (isset($this->migrations[$name])) {
                 @unlink($this->paths[$name]);
                 unset($this->migrations[$name]);
                 unset($this->paths[$name]);
            }
       }




       /**
        * @return void
       */
       public function removeMigrations()
       {
           foreach ($this->migrations as $migration) {
                $this->removeMigration($migration->getName());
           }
       }
}