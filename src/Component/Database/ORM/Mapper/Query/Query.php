<?php
namespace Laventure\Component\Database\ORM\Mapper\Query;


use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;




/**
 * Query
*/
class Query
{


       /**
        * @var EntityManager
       */
       protected $em;



       /**
        * @var QueryInterface
       */
       protected $statement;




       /**
         * @param EntityManager $em
         * @param QueryInterface $statement
       */
       public function __construct(EntityManager $em, QueryInterface $statement)
       {
            $this->em = $em;
            $this->statement = $statement;
       }




       /**
         * Fetch all
         *
         * @return mixed
       */
       public function getResult()
       {
            $this->em->attaches($objects = $this->statement->fetchAll());

            return $objects;
       }





       /**
        * Fetch one
        *
        * @return mixed
       */
       public function getOneOrNullResult()
       {
            $this->em->attach($object = $this->statement->fetchOne());

            return $object;
       }




       /**
        * Fetch column
        *
        * @return mixed
       */
       public function getArrayColumns()
       {
            return $this->statement->fetchColumns();
       }




       /**
         * Rows count
         *
         * @return int|mixed
       */
       public function count()
       {
             return $this->statement->rowCount();
       }





       /**
        * Get errors
        *
        * @return mixed
       */
       public function getErrors()
       {
           return $this->statement->errors();
       }




       /**
         * Get queries log
         *
         * @return array|mixed
       */
       public function getQueryLog()
       {
            return $this->statement->getQueryLog();
       }
}