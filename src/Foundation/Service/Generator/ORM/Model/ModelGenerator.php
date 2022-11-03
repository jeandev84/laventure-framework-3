<?php
namespace Laventure\Foundation\Service\Generator\ORM\Model;

use Laventure\Foundation\Service\Generator\File\ClassGenerator;

class ModelGenerator extends ClassGenerator
{

        /**
         * @param $model
         * @return string|null
        */
       public function generateModelClass($model): ?string
       {
             $credentials = array_merge([
                 "DummyStubPath"  => "database/orm/model/template",
                 "DummyClass"     => $model
             ]);

             return $this->generateClass($credentials);
       }
}