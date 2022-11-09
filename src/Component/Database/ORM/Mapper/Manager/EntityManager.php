<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;


use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Contact\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Event\Contract\EntityEventManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Exception\EntityManagerException;
use Laventure\Component\Database\ORM\Mapper\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Mapper\Repository\Factory\EntityRepositoryFactory;
use Laventure\Component\Database\ORM\Mapper\Service\ClassMapper;


/**
 *
*/
class EntityManager implements EntityManagerInterface
{


       /**
        * @var ConnectionInterface
       */
       protected $connection;




       /**
        * @var Persistence
       */
       protected $persistence;



       /**
        * @var EntityRepositoryFactory
       */
       protected $repositoryFactory;





       /**
        * @var EntityEventManagerInterface
       */
       protected $eventManager;





       /**
        * @var ClassMapper
       */
       protected $classMap;





       /**
        * @var array
       */
       protected $attached = [];





       /**
        * EntityManager constructor.
        *
        * @param ConnectionInterface $connection
        * @param EntityRepositoryFactory $repositoryFactory
        * @param EntityEventManagerInterface $eventManager
       */
       public function __construct(ConnectionInterface $connection, EntityRepositoryFactory $repositoryFactory, EntityEventManagerInterface $eventManager)
       {
             $this->connection        = $connection;
             $this->repositoryFactory = $repositoryFactory;
             $this->eventManager      = $eventManager;
             $this->persistence       = new Persistence($this);
             $this->classMap          = new ClassMapper();
       }





       /**
        * Return entity event manager
        *
        * @return EntityEventManagerInterface
       */
       public function getEventManager(): EntityEventManagerInterface
       {
             return $this->eventManager;
       }








       /**
        * @return ConnectionInterface
       */
       public function getConnectionManager(): ConnectionInterface
       {
            return $this->connection;
       }




       /**
        * @return Persistence
       */
       public function getPersistence(): Persistence
       {
            return $this->persistence;
       }




       /**
        * @return mixed
       */
       public function getConnection()
       {
            return $this->connection->getConnection();
       }




       /**
        * @inheritDoc
       */
       public function classMap(): ClassMapper
       {
            return $this->classMap;
       }




       /**
        * @inheritDoc
       */
       public function registerClass($class): self
       {
             $this->classMap->map($class);

             return $this;
       }






       /**
        * @return string
       */
       public function getTableName(): string
       {
            return $this->classMap->createTableName();
       }




       /**
        * @inheritdoc
       */
       public function getRepository($entityClass): EntityRepository
       {
             return $this->repositoryFactory->createRepository($entityClass);
       }







       /**
        * Attach object
        *
        * @param object $object
        * @return $this
       */
       public function attach($object): self
       {
             if($index = $this->persistence->getObjectID($object)) {
                  $this->attached[$index] = $object;
                  $this->persist($object);
             }

             return $this;
       }




       /**
        * Detach object
        *
        * @param $object
        * @return void
       */
       public function detach($object)
       {
            if($index = $this->persistence->getObjectID($object)) {
                unset($this->attached[$index]);
            }
       }




       /**
        * @param array $objects
        * @return void
       */
       public function attaches(array $objects)
       {
           foreach ($objects as $object) {
              $this->attach($object);
           }
       }




       /**
        * @param array $objects
        * @return void
       */
       public function detaches(array $objects)
       {
            foreach ($objects as $object) {
                $this->detach($object);
            }
       }






       /**
        * @return string
       */
       public function getClassName(): string
       {
            return $this->classMap->className();
       }



       /**
        * Persist object data
        *
        * @param $object
        * @return $this
       */
       public function persist($object): self
       {
            $this->persistence->persist($object);

            return $this;
       }




       /**
        * Remove object data
        *
        * @param $object
        * @return $this
       */
       public function remove($object): self
       {
           $this->persistence->remove($object);

           return $this;
       }




       /**
         * Save changes
         *
         * @return void
       */
       public function flush()
       {
            $this->persistence->flush();
       }




       /**
        * @param string $sql
        *  @param array $params
        * @return QueryInterface
       */
       public function statement(string $sql, array $params = []): QueryInterface
       {
             $statement = $this->connection->statement($sql, $params);
             $statement->map($this->getClassName());
             return $statement;
       }




       /**
        * Create Query Builder
        *
        * @return QueryBuilder
       */
       public function createQueryBuilder(): QueryBuilder
       {
            return new QueryBuilder($this);
       }





       /**
        * @param array $attributes
        * @return false|int
       */
       public function insert(array $attributes)
       {
            return $this->createQueryBuilder()->insert($attributes);
       }




       /**
        * @param array $attributes
        * @param array $wheres
        * @return bool
       */
       public function update(array $attributes, array $wheres): bool
       {
             $queryBuilder = $this->createQueryBuilder();
             $command = $queryBuilder->update($attributes, $wheres);

             // echo "Look at here: ". __METHOD__;
             // dd($command->getSQL(), $command->getParameters());
             return $command->execute();
       }




       /**
         * @param array $wheres
         * @return bool
       */
       public function delete(array $wheres): bool
       {
            $queryBuilder = $this->createQueryBuilder();
            $queryBuilder->criteria($wheres);
            $command = $queryBuilder->delete();

            return $command->execute();
       }



       /**
         * @inheritDoc
       */
       public function beginTransaction()
       {
            return $this->connection->beginTransaction();
       }



       /**
         * @inheritDoc
       */
       public function commit()
       {
            return $this->connection->commit();
       }




       /**
         * @inheritDoc
       */
       public function rollback()
       {
            return $this->connection->rollback();
       }




       /**
        * @inheritDoc
       */
       public function lastId(): int
       {
           return $this->persistence->getId();
       }





       /**
         * @inheritDoc
       */
       public function transaction(Closure $closure)
       {
           try {

               $this->beginTransaction();

               $closure($this);

               $this->commit();

           } catch (\Exception $e) {

               $this->rollback();

               $this->createEntityManagerException($e->getMessage());
           }
       }




       /**
        * @param string $message
        * @return EntityManagerException
       */
       protected function createEntityManagerException(string $message): EntityManagerException
       {
            return (function () use ($message) {
                 throw new EntityManagerException($message);
            })();
       }

}