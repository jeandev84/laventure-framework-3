<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository\Factory;

use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;


/**
 * EntityRepositoryFactory
*/
abstract class EntityRepositoryFactory
{
      /**
       * @param string $class
       * @return EntityRepositoryInterface
      */
      abstract public function createRepository(string $class): EntityRepositoryInterface;
}