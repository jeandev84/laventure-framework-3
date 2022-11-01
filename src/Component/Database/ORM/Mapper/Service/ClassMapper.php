<?php
namespace Laventure\Component\Database\ORM\Mapper\Service;


use Laventure\Component\Database\ORM\Mapper\Service\Exception\ClassMapperException;

/**
 * ClassMapper
*/
class ClassMapper
{

      /**
       * @var string
      */
      protected $table;



      /**
       * @var string
      */
      protected $className;



      /**
       * @param string $className
       * @return $this
      */
      public function mapClass(string $className): self
      {
           $this->className = $className;

           return $this;
      }




      /**
       * @param string $table
       * @return $this
      */
      public function withTable(string $table): self
      {
           $this->table = $table;

           return $this;
      }



      /**
       * @return string
      */
      public function createTableName(): string
      {
          if($this->table) {
               return $this->table;
          }

          if (! $this->className) {
               $this->createClassMapperException("Empty class name inside : ". __METHOD__);
          }

          return (function () {

              $shortName = (new \ReflectionClass($this->className))->getShortName();

              return mb_strtolower(trim($shortName, 's')) . 's';

          })();
      }


      
      /**
       * @return string
      */
      public function getClassName(): string
      {
          return $this->className;
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