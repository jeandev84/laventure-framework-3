<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\Contract;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;



/**
 * Fixture
*/
interface Fixture
{

     /**
      * Load data
      *
      * @param EntityManager $manager
      * @return void
    */
    public function load(EntityManager $manager);
}