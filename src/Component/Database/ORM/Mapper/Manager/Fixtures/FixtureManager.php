<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Fixtures;

use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\Contract\Fixture;



/**
 * @class FixtureManager
*/
class FixtureManager
{

       /**
        * @var EntityManager
       */
       protected $em;






       /**
        * Store fixtures
        *
        * @var Fixture[]
       */
       protected $fixtures = [];





      /**
       * FixtureManager constructor.
       *
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
           $this->em = $em;
      }




      /**
       * @param Fixture[] $fixtures
       *
       * @return void
      */
      public function addFixtures(array $fixtures)
      {
          foreach ($fixtures as $fixture) {
               $this->addFixture($fixture);
          }
      }






      /**
       * Add fixture
       *
       * @param Fixture $fixture
       * @return $this
      */
      public function addFixture(Fixture $fixture): self
      {
           $this->fixtures[] = $fixture;

           return $this;
      }






      /**
       * Returns fixture collection
       *
       * @return Fixture[]
      */
      public function getFixtures(): array
      {
           return $this->fixtures;
      }





      /**
       * Load all fixtures
       *
       * @return array
      */
      public function loadFixtures(): array
      {
           $fixtures = [];

           foreach ($this->fixtures as $fixture) {
               $fixture->load($this->em);
               $fixtures[] = get_class($fixture);
           }

           return $fixtures;
      }
}