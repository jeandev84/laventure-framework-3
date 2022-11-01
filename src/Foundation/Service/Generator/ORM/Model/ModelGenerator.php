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
                 "DummyStubPath"  => "database/orm/model/template",
                 "DummyNamespace" => "App\\Model",
                 "DummyPath"      => 'app/Model'
             ], $credentials);

             return $this->generateClass($credentials);
       }
}