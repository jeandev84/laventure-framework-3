<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository;

use Laventure\Component\Database\ORM\Mapper\Manager\Contact\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;


/**
 *
*/
class ServiceRepository extends EntityRepository
{
       /**
        * @param EntityManager $em
        * @param string $entityClass
       */
       public function __construct(EntityManager $em, string $entityClass)
       {
             parent::__construct($em, $entityClass);
       }
}