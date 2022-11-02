<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;

use Laventure\Foundation\Service\Generator\File\ClassGenerator;


/**
 * @class FixtureGenerator
*/
class FixtureGenerator extends ClassGenerator
{

       /**
        * Return path of generated class
        *
        * @param $fixture
        * @return string|null
       */
       public function generateFixture($fixture): ?string
       {
            $fixture  = str_replace('Fixture', '', $fixture);
            $fixture  = sprintf('%sFixture', ucfirst($fixture));

            $credentials = [
                "DummyStubPath"  => "database/orm/mapper/fixtures/template",
                "DummyNamespace" => "App\\Fixtures",
                "DummyClass"     => $fixture,
                "DummyPath"      => "app/Fixtures",
            ];

            return $this->generateClass($credentials);
       }
}