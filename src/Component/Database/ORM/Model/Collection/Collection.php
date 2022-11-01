<?php
namespace Laventure\Component\Database\ORM\Model\Collection;

class Collection
{

      /**
       * @var array
      */
      protected $items = [];


      /**
       * @param array $items
      */
      public function __construct(array $items)
      {
           $this->items = $items;
      }



      /**
       * @return array
      */
      public function all(): array
      {
          return $this->items;
      }
}