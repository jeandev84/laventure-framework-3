<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository\Factory;

use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\EntityRepository;


/**
 * EntityRepositoryFactory
*/
abstract class EntityRepositoryFactory
{
      /**
       * @param string $class
       * @return EntityRepository
      */
      abstract public function createRepository(string $class): EntityRepository;
}