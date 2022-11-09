<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository\Contract;

/**
 *
*/
interface EntityRepositoryInterface
{

       /**
        * Returns all records
        *
        * @return mixed
       */
       public function findAll();





       /**
        * Returns all records by given criteria
        *
        * @param $criteria
        * @return mixed
       */
       public function findBy($criteria);
}