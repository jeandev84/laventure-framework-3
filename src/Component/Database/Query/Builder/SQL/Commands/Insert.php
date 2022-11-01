<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Commands;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 *
*/
class Insert extends SqlBuilder
{

       /**
        * @var array
       */
       protected $attributes = [];




       /**
        * @var array
       */
       protected $columns = [];
       

       
       
       /**
        * @param array $attributes
        * @param string $table
       */
       public function __construct(array $attributes, string $table)
       {
             parent::__construct($table);

             $this->addMultiAttributes($attributes);
       }




       /**
        * @param array $attributes
        * @return void
       */
       public function addAttribute(array $attributes)
       {
            $this->columns = array_keys($attributes);

            $this->attributes[] = $attributes;
       }




       /**
        * @param array $attributes
        * @return void
       */
       public function addAttributes(array $attributes) {

            foreach ($attributes as $parameters) {
                 $this->addAttribute($parameters);
            }
       }


       

       /**
        * @return string
       */
       protected function makeInsertionColumns(): string
       {
            return implode(', ', $this->columns);
       }

       
       
       

       /**
        * @return array
       */
       public function getAttributes(): array
       {
            return $this->attributes;
       }




       /**
        * @return string
       */
       protected function openSQL(): string
       {
            return sprintf('INSERT INTO %s (%s) VALUES %s',
                   $this->getTable(),
                   $this->makeInsertionColumns(),
                   $this->makeInsertionValues()
            );
     }





     /**
      * @return string
     */
     protected function closeSQL(): string
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
      * @param array $attributes
      * @return void
     */
     public function addMultiAttributes(array $attributes)
     {
          if (! empty($attributes[0])) {
             $this->addAttributes($attributes);
          }else{
             $this->addAttribute($attributes);
          }
     }
}