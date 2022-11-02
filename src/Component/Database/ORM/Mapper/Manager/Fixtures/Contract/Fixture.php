<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\Contract;

use Laventure\Component\Database\ORM\Mapper\Manager\Contact\ObjectManager;

/**
 * Fixture
*/
interface Fixture
{
     /**
      * Load data
      *
      * @param ObjectManager $manager
      * @return void
    */
    public function load(ObjectManager $manager);
}