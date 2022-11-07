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




    public function boot()
    {
        $this->app->singleton(EntityEventManagerInterface::class, $this->app->make(EntityEventManager::class));

        $this->app->singleton(EntityRepositoryFactory::class, function () {
            return $this->app->make(RepositoryFactory::class, [
                'namespace' => \config()->get("namespaces.repositories")
            ]);
        });
    }





    /**
     * @inheritDoc
    */
    public function register()
    {
         // Sharing
        $connection  = config()->get('database.connection');
        $credentials = config()->get('database')[$connection] ?? [];

        /** @var Manager $manager */
        $manager = $this->app->factory(Manager::class);
        $manager->addConnection($credentials);
        $this->app->singleton(ConnectionInterface::class, $manager->connection());
        $manager->setEntityManager($this->app->make(EntityManager::class));

        $this->app->singleton(Manager::class, $manager);
        $this->app->singleton(EntityManager::class, $manager->getEntityManager());
        $this->app->singleton(Schema::class, $manager->schema());
        $this->app->singleton(Migrator::class, $manager->migration());
    }
}