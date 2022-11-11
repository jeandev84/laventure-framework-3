<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Command;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 *
*/
class Insert extends SqlBuilder
{


       /**
        * @var array
       */
       protected $columns = [];




       /**
        * @var array
       */
       protected $values  = [];






       /**
        * @var array
       */
       protected $attributes = [];





       /**
        * Add attributes
        *
        * @param array $attributes
        * @return $this
       */
       public function add(array $attributes): self
       {
            $this->columns      = array_keys($attributes);
            $this->values[]     = array_values($attributes);
            $this->attributes[] = $attributes;

            return $this;
       }







       /**
        * Refresh all attributes
        *
        * @return void
       */
       public function refresh()
       {
           $this->columns      = [];
           $this->values[]     = [];
           $this->attributes[] = [];
       }

       



       /**
        * @return array
       */
       public function getAttributes(): array
       {
            return $this->attributes;
       }






       /**
        * @param array $replaces
        * @return void
       */
       public function refreshValues(array $replaces)
       {
            $this->values = array_replace($this->values, $replaces);
       }





       /**
        * @return string
       */
       protected function buildValues(): string
       {
             $values = [];

             foreach ($this->values as $data) {
                 $values[] = "(". join(",", $data) . ")";
             }

             return join(", ", $values);
       }





       /**
        * Build columns
        *
        * @return string
       */
       protected function buildColumns(): string
       {
           return join(', ', $this->columns);
       }





       /**
        * @return string
       */
       protected function openQuery(): string
       {
            $command = "INSERT INTO {$this->getTable()}";

            if (! empty($this->affected)) {
                 $this->attributes = [];
                 return $command;
            }

            return sprintf("%s (%s) VALUES %s", $command, $this->buildColumns(), $this->buildValues());
      }





     /**
      * @return string
     */
     protected function closeQuery(): string
     {
           return '';
     }





     /**
      * @return string
     */
     protected function makeInsertionValues(): string
     {
          $insertions = [];
          
          foreach ($this->getAttributes() as $attribute) {
              $insertions[] = "('" . implode("', '", array_values($attribute)) . "')";
          }
          
          return join(', ', $insertions);
     }






     /**
      * @param string $condition
      * @return SqlBuilder
     */
     public function where(string $condition): SqlBuilder
     {
           return $this;
     }
}