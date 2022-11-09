<?php
namespace Laventure\Component\Database\ORM\Mapper\Service;


use Laventure\Component\Database\ORM\Mapper\Service\Exception\ClassMapperException;

/**
 * ClassMapper
*/
class ClassMapper
{

      /**
       * @var object|string
      */
      protected $mapped;






      /**
       * @param $mapped
       * @return $this
      */
      public function map($mapped): self
      {
           $this->mapped = $mapped;

           return $this;
      }





      /**
       * @return string
      */
      public function createTableName(): string
      {
          if (! $this->mapped) {
               $this->createClassMapperException(
                   "Could not create table name because unknown class name :". __METHOD__
               );
          }

          return (function () {
              $shortname = (new \ReflectionClass($this->mapped))->getShortName();
              return mb_strtolower(trim($shortname, 's')) . 's';
          })();
      }





      /**
       * @return string
      */
      public function className(): string
      {
           if (is_object($this->mapped)) {
                return get_class($this->mapped);
           }

           return $this->mapped;
      }




      /**
       * @param $message
       * @return mixed
      */
      protected function createClassMapperException($message)
      {
           return (function () use ($message) {
               throw new ClassMapperException($message);
           })();
      }
}