<?php
namespace Laventure\Component\Database\Schema\BluePrint\Keys;

class Constrained
{

     /**
      * @var string[]
     */
     protected $items = [
         'onDelete' => '',
         'onUpdate' => '',
     ];


     /**
      * @param $type
      * @return $this
     */
     public function onDelete($type): self
     {
          $this->items['onDelete'] = "ON DELETE $type";

          return $this;
     }




     /**
      * @return $this
     */
     public function onDeleteCascade(): self
     {
          return $this->onDelete('cascade');
     }



     /**
      * @param $type
      * @return $this
     */
     public function onUpdate($type): self
     {
          $this->items['onUpdate'] = "ON UPDATE $type";

          return $this;
     }



     /**
      * @return string
     */
     public function __toString()
     {
          $constrained = implode(' ', array_values($this->items));

          return strtoupper($constrained);
     }
}