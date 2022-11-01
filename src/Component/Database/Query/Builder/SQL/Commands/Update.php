<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Commands;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 *
*/
class Update extends SqlBuilder
{


     protected $attributes = [];




     /**
      * @param array $attributes
      * @param string $table
     */
     public function __construct(array $attributes, string $table)
     {
           parent::__construct($table);

           $this->setColumns($attributes);
     }




     /**
      * @return string
     */
     protected function openSQL(): string
     {
         return sprintf("UPDATE %s %s", $this->getTable(), $this->makeSET());
     }
}