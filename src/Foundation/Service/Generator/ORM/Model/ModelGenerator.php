<?php
namespace Laventure\Foundation\Service\Generator\ORM\Model;

use Laventure\Foundation\Service\Generator\ClassGenerator;

class ModelGenerator extends ClassGenerator
{

       /**
        * @param array $credentials
        * @return string|null
       */
       public function generateModelClass(array $credentials): ?string
       {
             $credentials = array_merge([
                 "DummyNamespace" => "App\\Model",
                 "DummyPath"      => 'app/Model'
             ], $credentials);

             return $this->generateClass($credentials);
       }




       /**
        * @inheritDoc
       */
       protected function dummyStubPath(): string
       {
           return 'database/orm/model/template';
       }
}