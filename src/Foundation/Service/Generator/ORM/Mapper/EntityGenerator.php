<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;


use Laventure\Foundation\Service\Generator\File\ClassGenerator;

/**
 *
*/
class EntityGenerator extends ClassGenerator
{

      /**
       * @param array $credentials
       * @return string|null
      */
      public function generateEntityClass(array $credentials): ?string
      {
           $credentials = array_merge([
               "DummyStubPath"  => "database/orm/mapper/entity/template",
               "DummyNamespace" => "App\\Entity",
               "DummyPath"      => "app/Entity"
           ], $credentials);

           return $this->generateClass($credentials);
      }
}