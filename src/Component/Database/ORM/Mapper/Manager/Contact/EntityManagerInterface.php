<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Contact;


use Closure;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Mapper\Service\ClassMapper;


/**
 *
*/
interface EntityManagerInterface extends ObjectManager
{

       /**
        * @return mixed
       */
       public function getConnection();




       /**
        * @param $class
        * @return mixed
       */
       public function registerClass($class);





      /**
       * @param $entityClass
       * @return EntityRepository
      */
      public function getRepository($entityClass): EntityRepository;





      /**
       * @return ClassMapper
      */
      public function classMap(): ClassMapper;





      /**
       * @return mixed
      */
      public function flush();




      /**
       * @return mixed
      */
      public function beginTransaction();




      /**
       * @return mixed
      */
      public function commit();




      /**
       * @return mixed
      */
      public function rollback();




      /**
       * Get last insert id
       *
       * @return int
      */
      public function lastId(): int;




      /**
       * @param Closure $closure
       * @return mixed
      */
      public function transaction(Closure $closure);
}