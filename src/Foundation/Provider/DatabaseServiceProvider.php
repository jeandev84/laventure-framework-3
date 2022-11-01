<?php
namespace Laventure\Foundation\Provider;

use Laventure\Component\Config\Config;
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
use Laventure\Component\Database\ORM\OrmType;
use Laventure\Component\Database\Schema\Schema;
use Laventure\Foundation\Database\ORM\Mapper\Repository\Factory\RepositoryFactory;


/**
 *
*/
class DatabaseServiceProvider extends ServiceProvider
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
     * @inheritDoc
    */
    public function register()
    {
         // Sharing
         $this->shareDatabaseManager();
         $this->shareConnection();
         $this->shareEntityManager();
         $this->shareSchema();
         $this->shareMigrator();
    }







    /**
     * @return void
    */
    private function shareDatabaseManager()
    {
        $this->app->singleton(Manager::class, function (Config $config) {

            $connection  = $config->get('database.connection');
            $credentials = $config->get('database')[$connection] ?? [];

            /** @var Manager $manager */
            $manager = $this->app->factory(Manager::class);
            $manager->addConnection($credentials);
            $manager->orm($config->get('database.orm'));

            return $manager;

        });
    }





    /**
     * @return void
    */
    private function shareConnection()
    {
        $this->app->singleton(ConnectionInterface::class, function (Manager $manager) {
               return $manager->connection();
        });
    }





    /**
     * @return void
    */
    private function shareSchema()
    {
         $this->app->singleton(Schema::class, function (Manager $manager) {
              return $manager->schema();
         });
    }






    /**
     * @return void
    */
    private function shareMigrator()
    {
         $this->app->singleton(Migrator::class, function (Manager $manager) {
             return  $manager->migration();
         });
    }




    /**
     * @return void
    */
    private function shareEntityManager()
    {
        $this->app->singleton(
     EntityEventManagerInterface::class,
            $this->app->make(EntityEventManager::class)
        );


        $this->app->singleton(EntityManager::class, function (Manager $manager) {

            $factory = $this->app->make(RepositoryFactory::class, [
                'namespace' => "App\\Repository"
            ]);

            $this->app->instance(EntityRepositoryFactory::class, $factory);

            $em = $this->app->make(EntityManager::class);

            $manager->setEntityManager($em);

            return $em;

        });
    }
}