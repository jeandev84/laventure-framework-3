<?php
namespace Laventure\Component\Database\Migration;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Migration\Contract\MigrationInterface;
use Laventure\Component\Database\Schema\Schema;
use ReflectionClass;


/**
 * Migration
*/
abstract class Migration implements MigrationInterface
{


     /**
      * Get migration name
      *
      * @return string
     */
     public function getName(): string
     {
          return $this->reflection()->getShortName();
     }




     /**
      * Get full path to migration
      *
      * @return string
     */
     public function getPath(): string
     {
          return $this->reflection()->getFileName();
     }




     /**
      * @return ReflectionClass
     */
     private function reflection(): ReflectionClass
     {
          return new ReflectionClass(get_called_class());
     }
}
