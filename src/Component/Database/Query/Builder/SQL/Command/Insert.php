<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Command;

use Exception;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 *
*/
class Insert extends SqlBuilder
{

       /**
        * @var int
       */
       protected $index = 1;




       /**
        * @var array
       */
       protected $data = [];




       /**
        * @var array
       */
       protected $columns = [];





       /**
        * @var array
       */
       protected $values  = [];






       /**
        * @param array $data
        * @return $this
       */
       public function data(array $data): self
       {
            if (isset($data[0])) {
                foreach ($data as $attributes) {
                     $this->add($attributes);
                }
            } else {
                $this->add($data);
            }

            return $this;
       }






       /**
        * @param array $columns
        * @return $this
       */
       public function columns(array $columns): self
       {
             $this->columns = array_keys($columns[0] ?? $columns);

             return $this;
       }






       /**
        * @param array $attributes
        * @return $this
       */
       public function add(array $attributes): self
       {
             $credentials = [];

             foreach ($attributes as $column => $value) {
                  $credentials[$column = "{$column}{$this->index}"] = $value;
                  $this->setParameter($column, $value);
             }

             $this->data[]   = $credentials;
             $this->values[] = array_values($credentials);

             $this->index++;

             return $this;
       }






       /**
        * @param array $values
        * @return void
       */
       public function refreshValues(array $values)
       {
            $this->values = array_replace($this->values, $values);
       }






       /**
        * Return values
        *
        * @return array
       */
       public function getValues(): array
       {
            return $this->values;
       }




       /**
        * @return array
       */
       public function getData(): array
       {
            return $this->data;
       }




       /**
        * @return string
       */
       protected function buildValues(): string
       {
           $values = [];

           foreach ($this->getValues() as $data) {
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
            $sql = "INSERT INTO {$this->getTable()}";

            if (! $this->data) {
                return $sql;
            }

            return sprintf("%s (%s) VALUES %s", $sql, $this->buildColumns(), $this->buildValues());
      }





     /**
      * @return string
     */
     protected function closeQuery(): string
     {
           return '';
     }





     /**
      * @param string $condition
      * @return SqlBuilder
      * @throws Exception
     */
     public function where(string $condition): SqlBuilder
     {
           throw new Exception("Unable to execute : " . __METHOD__);
     }
}