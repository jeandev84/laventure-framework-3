<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Config\Config;
use Laventure\Component\Container\Provider\Contract\BootableServiceProvider;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Manager\Contact\DatabaseManagerInterface;
use Laventure\Component\Database\Manager\DatabaseManager;
use Laventure\Component\Database\Migration\Migrator;
use Laventure\Component\Database\ORM\Manager;
use Laventure\Component\Database\ORM\Mapper\Manager\Contact\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Manager\Event\Contract\EntityEventManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Event\EntityEventManager;
use Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\Contract\Fixture;
use Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\FixtureManager;
use Laventure\Component\Database\ORM\Mapper\Repository\Factory\EntityRepositoryFactory;
use Laventure\Component\Database\Schema\Schema;
use Laventure\Foundation\Database\ORM\Mapper\Repository\Factory\RepositoryFactory;


/**
 * @class DatabaseServiceProvider
 *
 * @package Laventure\Foundation\Service\Provider
*/
class DatabaseServiceProvider extends ServiceProvider implements BootableServiceProvider
{


    /**
     * @inheritdoc
    */
    protected $provides = [
        Manager::class => [DatabaseManager::class, DatabaseManagerInterface::class, 'db'],
        ConnectionInterface::class => ['connection'],
        EntityManager::class => [EntityManagerInterface::class, 'em'],
        Schema::class => ['schema'],
        Migrator::class  => ['migrator']
    ];




    /**
     * @var Manager
    */
    private $manager;




    public function boot()
    {
        /** @var Manager $manager */
        $manager = $this->app->factory(Manager::class);
        $manager->addConnection($this->connectionCredentials());

        $this->manager = $manager;
    }





    /**
     * @inheritDoc
    */
    public function register()
    {
        $this->app->singleton(EntityEventManagerInterface::class, function () {
             return $this->app->make(EntityEventManager::class);
        });

        $this->app->singleton(EntityRepositoryFactory::class, function () {
            return $this->app->make(RepositoryFactory::class, [
                'namespace' => \config()->get("namespaces.repositories")
            ]);
        });

        $this->app->singleton(ConnectionInterface::class, function () {
            return $this->manager->connection();
        });

        $this->app->singleton(Manager::class, function () {
            $this->manager->setEntityManager($this->app->make(EntityManager::class));
            return $this->manager;
        });


        $this->app->singleton(EntityManager::class, $this->manager->getEntityManager());
        $this->app->singleton(FixtureManager::class, function () {
             $fixtureManager = $this->app->make(FixtureManager::class);
             $fixtureManager->addFixtures($this->getFixtures());
             return $fixtureManager;
        });

        $this->app->singleton(Schema::class, $this->manager->schema());
        $this->app->singleton(Migrator::class, $this->manager->migration());
    }





    /**
     * @return Fixture[]
    */
    private function getFixtures(): array
    {
         $fixturePath = \config()->get("paths.fixtures");
         $namespaces  = \config()->get("namespaces.fixtures");

         $fixtures = [];

         if($files = fs()->collection("{$fixturePath}/*")->names()) {
             foreach ($files as $file) {
                 $fixture = $this->app->get("{$namespaces}\\{$file}");
                 if ($fixture instanceof Fixture) {
                     $fixtures[] = $fixture;
                 }
             }
         }

         return $fixtures;
    }





    /**
     * @return array|mixed
    */
    private function connectionCredentials()
    {
        $connection  = config()->get('database.connection');

        return config()->get('database')[$connection] ?? [];
    }
}