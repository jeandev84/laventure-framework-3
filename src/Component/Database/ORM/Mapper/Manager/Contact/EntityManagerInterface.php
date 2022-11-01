<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Contact;


use Closure;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
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
        * @param $entityClass
        * @return void
       */
       public function registerClass($entityClass);



      /**
       * @param $entityClass
       * @return EntityRepositoryInterface
      */
      public function getRepository($entityClass): EntityRepositoryInterface;





      /**
       * @return ClassMapper
      */
      public function getClassMap(): ClassMapper;





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
      public function lastInsertId(): int;




      /**
       * @param Closure $closure
       * @return mixed
      */
      public function transaction(Closure $closure);
}