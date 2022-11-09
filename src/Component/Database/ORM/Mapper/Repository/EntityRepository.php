<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository;

use Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL\Commands\SelectBuilder;
use Laventure\Component\Database\ORM\Mapper\Manager\Contact\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;


/**
 *
*/
abstract class EntityRepository implements EntityRepositoryInterface
{


       use EntityRepositoryResolver;


       /**
        * @var EntityManagerInterface
       */
       protected $em;




       /**
        * @param EntityManager $em
        * @param string $entityClass
       */
       public function __construct(EntityManager $em, string $entityClass)
       {
             $em->registerClass($entityClass);
             $this->em = $em;
       }




       /**
        * @return string
       */
       protected function getTableName(): string
       {
            return $this->em->getTableName();
       }





       /**
        * Create native query builder
        *
        * @return QueryBuilder
       */
       public function createQB(): QueryBuilder
       {
            return $this->em->createQueryBuilder();
       }





        /**
         * @param string|null $alias
         * @return SelectBuilder
        */
        public function select(string $alias = null): SelectBuilder
        {
            return $this->createQB()
                        ->select(['*'])
                        ->from($this->getTableName(), $alias);
        }



       /**
        * @param array $wheres
        * @return mixed
       */
       public function findOneBy(array $wheres)
       {
            $command = $this->findByCriteria($wheres);

            return $command->getQuery()->getOneOrNullResult();
       }




       /**
        * @param $criteria
        * @return mixed
       */
       public function findBy($criteria)
       {
           $command = $this->findByCriteria($criteria);

           return $command->getQuery()->getResult();
       }




       /**
        * @return mixed
       */
       public function findAll()
       {
            return  $this->createQB()
                         ->select()
                         ->getQuery()
                         ->getResult();
       }






       /**
        * @param array $wheres
        * @return SelectBuilder|Select
       */
       public function findByCriteria(array $wheres)
       {
           $queryBuilder = $this->createQB();
           $queryBuilder->criteria($wheres);
           return $queryBuilder->select();
       }




       /**
        * @param $name
        * @param $arguments
        * @return mixed
       */
       public function __call($name, $arguments)
       {
            return $this->resolveCallbackMethods($name, $arguments);
       }
}