<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;


use Laventure\Foundation\Service\Generator\ClassGenerator;

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
               "DummyNamespace" => "App\\Entity",
               "DummyPath"      => "app/Entity"
           ], $credentials);

           return $this->generateClass($credentials);
      }



      /**
       * @inheritDoc
      */
      protected function dummyStubPath(): string
      {
          return 'database/orm/mapper/template/entity';
      }
}