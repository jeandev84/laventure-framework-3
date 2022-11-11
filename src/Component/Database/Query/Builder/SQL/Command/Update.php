<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Command;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 *
*/
class Update extends SqlBuilder
{


     /**
      * @return string
     */
     protected function openQuery(): string
     {
         return sprintf("UPDATE %s", $this->getTable());
     }
}