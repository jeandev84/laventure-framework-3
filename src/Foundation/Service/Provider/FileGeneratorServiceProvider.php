<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Foundation\Service\Generator\Command\CommandGenerator;
use Laventure\Foundation\Service\Generator\Controller\ApiControllerGenerator;
use Laventure\Foundation\Service\Generator\Controller\ControllerGenerator;
use Laventure\Foundation\Service\Generator\Migration\MigrationGenerator;
use Laventure\Foundation\Service\Generator\ORM\Mapper\EntityGenerator;
use Laventure\Foundation\Service\Generator\ORM\Mapper\EntityRepositoryGenerator;
use Laventure\Foundation\Service\Generator\ORM\Mapper\FixtureGenerator;
use Laventure\Foundation\Service\Generator\ORM\Model\ModelGenerator;


/**
 * @class FileGeneratorServiceProvider
 *
 * @package Laventure\Foundation\Provider
*/
class FileGeneratorServiceProvider extends ServiceProvider
{

    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(CommandGenerator::class, function () {
            $generator = $this->app->make(CommandGenerator::class);
            $generator->configs([
                "DummyNamespace" => config()->get('namespaces.commands'),
                "DummyPath"      => config()->get('paths.commands'),
            ]);
            return $generator;
        });

        $this->app->singleton(ControllerGenerator::class, function () {
            $generator = $this->app->make(ControllerGenerator::class);
            $generator->configs([
                "DummyNamespace" => config()->get('namespaces.controllers.web'),
                "DummyPath"      => config()->get('paths.controllers.web'),
            ]);
            return $generator;
        });


        $this->app->singleton(ApiControllerGenerator::class, function () {
            $generator = $this->app->make(ApiControllerGenerator::class);
            $generator->configs([
                "DummyNamespace" => config()->get('namespaces.controllers.api'),
                "DummyPath"      => config()->get('paths.controllers.api'),
            ]);
            return $generator;
        });


        $this->app->singleton(MigrationGenerator::class, function () {
            $generator = $this->app->make(MigrationGenerator::class);
            $generator->configs([
                "DummyNamespace" => config()->get('namespaces.migrations.mapper'),
                "DummyPath"      => config()->get('paths.migrations.mapper'),
            ]);
            return $generator;
        });



        $this->app->singleton(EntityGenerator::class, function () {
            $generator = $this->app->make(EntityGenerator::class);
            $generator->configs([
                "DummyNamespace" => config()->get('namespaces.entities'),
                "DummyPath"      => config()->get('paths.entities'),
            ]);
            return $generator;
        });


        $this->app->singleton(EntityRepositoryGenerator::class, function () {
            $generator = $this->app->make(EntityRepositoryGenerator::class);
            $generator->configs([
                "DummyNamespace"  => config()->get('namespaces.repositories'),
                "DummyPath"       => config()->get('paths.repositories'),
                "EntityNamespace" => config()->get('namespaces.entities')
            ]);
            return $generator;
        });


        $this->app->singleton(FixtureGenerator::class, function () {
            $generator = $this->app->make(FixtureGenerator::class);
            $generator->configs([
                "DummyNamespace"  => config()->get('namespaces.fixtures'),
                "DummyPath"       => config()->get('paths.fixtures')
            ]);
            return $generator;
        });



        $this->app->singleton(ModelGenerator::class, function () {
            $generator = $this->app->make(ModelGenerator::class);
            $generator->configs([
                "DummyNamespace"  => config()->get('namespaces.models'),
                "DummyPath"       => config()->get('paths.models')
            ]);
            return $generator;
        });
    }
}