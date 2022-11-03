<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;


use Laventure\Foundation\Service\Generator\File\ClassGenerator;

/**
 *
*/
class EntityGenerator extends ClassGenerator
{

      /**
       * @param $name
       * @return string|null
      */
      public function generateEntityClass($name): ?string
      {
           $credentials = array_merge([
               "DummyStubPath"  => "database/orm/mapper/entity/template",
               "DummyClass"     => $name
           ]);

           return $this->generateClass($credentials);
      }
}