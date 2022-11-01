<?php
namespace Laventure\Component\Database\ORM;



use Closure;
use Exception;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Types\PDO\PdoConnection;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Manager\DatabaseManager;
use Laventure\Component\Database\Migration\Migrator;
use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\Query\QueryBuilder;
use Laventure\Component\Database\Schema\Schema;
use PDO;


/**
 * Manager
*/
class Manager
{

      /**
        * @var self
      */
      protected static $instance;




      /**
       * @var DatabaseManager
      */
      protected $databaseManager;




      /**
       * @var EntityManager
      */
      protected $entityManager;





      /**
       * @var string
      */
      protected $modelPath;






      /**
       * @var string
      */
      protected $ormType;





      /**
       *  Constructor manager
      */
      public function __construct()
      {
           $this->databaseManager = new DatabaseManager();
      }





      /**
       * Set connections
       *
       * @param ConnectionInterface[] $connections
       * @return void
      */
      public function setConnections(array $connections)
      {
           $this->databaseManager->setConnections($connections);
      }





      /**
       * @param array $credentials
       * @return void
      */
      public function addConnection(array $credentials)
      {
           if (! static::$instance) {

               [$driver, $credentials] = $this->resolveCredentials($credentials);

               $this->databaseManager->connect($driver, $credentials);

               static::$instance = $this;
           }
      }




      /**
       * @param $name
       * @return void
      */
      public function orm($name)
      {
           $this->ormType = $name;
      }





      /**
       * @return string
      */
      public function getOrmType(): string
      {
           return $this->ormType;
      }





      /**
       * @return bool
      */
      public function hasOrmTypeModel(): bool
      {
          return $this->ormType === OrmType::MODEL;
      }






      /**
       * @return bool
      */
      public function hasOrmTypeMapper(): bool
      {
          return $this->ormType === OrmType::MAPPER;
      }




      /**
       * @param EntityManager $entityManager
       * @return $this
      */
      public function setEntityManager(EntityManager $entityManager): self
      {
            $this->entityManager = $entityManager;

            return $this;
      }




      /**
       * @return EntityManager
      */
      public function getEntityManager(): EntityManager
      {
           if (! $this->entityManager) {
                $this->createManagerException("Unable entity manager for ORM '{$this->ormType}");
           }

           return $this->entityManager;
      }




      /**
       * @return EntityManager
      */
      public function em(): EntityManager
      {
           return $this->getEntityManager();
      }





      /**
       * @param $name
       * @return ConnectionInterface
      */
      public function connection($name = null): ConnectionInterface
      {
           return $this->databaseManager->connection($name);
      }




      /**
       * @param string|null $name
       *  @return PdoConnection|null
      */
      public function pdoConnection(string $name = null): ?PdoConnection
      {
           $connection = $this->connection($name);

           if (! $connection instanceof PdoConnection) {
               return null;
           }

           return $connection;
      }




      /**
       * Get connection PDO driver
       *
       * @return PDO
      */
      public function pdo(): PDO
      {
           return $this->pdoConnection()->getPDO();
      }




      /**
       * @param string $sql
       * @param array $params
       * @return QueryInterface
      */
      public function query(string $sql, array $params = []): QueryInterface
      {
           return $this->connection()->statement($sql, $params);
      }




      /**
       * @param string|null $name
       * @return Schema
      */
      public function schema(string $name = null): Schema
      {
          $connection = $this->connection($name);

          return new  Schema($connection);
      }




      /**
       * @param string $name
       * @return QueryBuilder
      */
      public function table(string $name): QueryBuilder
      {
           return $this->makeQB($this->connection(), $name);
      }





      /**
       * Make QueryBuilder
       *
       * @param ConnectionInterface $connection
       * @param string $table
       * @return QueryBuilder
      */
      public function makeQB(ConnectionInterface $connection, string $table): QueryBuilder
      {
            return new QueryBuilder($connection, $table);
      }




      /**
       * Get instance of Manager
       *
       * @return $this
      */
      public static function make(): self
      {
           if (! static::$instance) {
                exit("add connection for checking instance of Manager.");
           }

           return self::$instance;
      }



      /**
       * @param $name
       * @return void
      */
      public function disconnect($name = null)
      {
           $this->databaseManager->disconnect($name);
      }




      /**
       * @return void
      */
      public function reconnect(string $name = null)
      {
           $this->databaseManager->reconnect($name);
      }



      /**
       * @return void
      */
      public function beginTransaction()
      {
          $this->connection()->beginTransaction();
      }





      /**
       * @return void
      */
      public function commit()
      {
           $this->connection()->commit();
      }




      /**
       * @return void
      */
      public function rollback()
      {
           $this->connection()->rollback();
      }





      /**
       * @param $name
       * @return int
      */
      public function lastId($name = null): int
      {
           return $this->connection()->lastInsertId($name);
      }




      /**
       * @param string $sql
       * @param array $params
       * @return QueryInterface
      */
      public function statement(string $sql, array $params = []): QueryInterface
      {
            return $this->connection()->statement($sql, $params);
      }




      /**
       * @param string $sql
       * @return bool
      */
      public function exec(string $sql): bool
      {
           return $this->connection()->exec($sql);
      }




      /**
       * @param Closure $queries
       * @return void
      */
      public function transaction(Closure $queries)
      {
          try {

               $this->beginTransaction();

               $queries($this);

               $this->commit();

          }  catch (Exception $e) {

              $this->rollback();

              $this->createManagerException($e->getMessage());
          }
      }




      /**
       * @return bool
      */
      public function existDatabase(): bool
      {
          $database = $this->getDatabase();

          $availableDatabases = $this->connection()->showDatabases();

          return ! is_null($database) && in_array($database, $availableDatabases);
      }





      /**
       * Determine if database successfully created
       *
       * @return bool
      */
      public function databaseCreated(): bool
      {
           return $this->createDatabase() && $this->existDatabase();
      }





      /**
       * @return bool
      */
      public function databaseDropped(): bool
      {
            return $this->dropDatabase() && (! $this->existDatabase());
      }



      /**
       * @return mixed
      */
      public function getDatabase()
      {
           return $this->connection()->getDatabase();
      }





      /**
       * @return bool
      */
      public function createDatabase(): bool
      {
          return $this->connection()->createDatabase();
      }




      /**
       * @return bool
      */
      public function dropDatabase(): bool
      {
           return $this->connection()->dropDatabase();
      }




      /**
       * @return Migrator
      */
      public function migration(): Migrator
      {
           return new Migrator($this->connection());
      }




      /**
       * @return string
      */
      public function getConnectionName(): string
      {
           return $this->connection()->getName();
      }




      /**
       * @return array
      */
      public function getQueryLog(): array
      {
           return [];
      }



      /**
       * @param array $credentials
       * @return array
      */
      protected function resolveCredentials(array $credentials): array
      {
           if (empty($credentials)) {
               $this->createManagerException("Empty credentials for connection to database.");
           }

           if (empty($credentials['driver'])) {
               $this->createManagerException("Unable 'driver name' for connection to database.". __METHOD__);
           }

           return [$credentials['driver'], $credentials];
      }




      /**
       * @param $message
       * @return ManagerException
      */
      public function createManagerException($message): ManagerException
      {
           return (function () use ($message) {
                 throw new ManagerException($message);
           })();
      }
}