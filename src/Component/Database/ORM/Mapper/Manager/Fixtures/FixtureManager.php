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
        * @var string[]
       */
       protected $messages = [];





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
       * @return void
      */
      public function loadFixtures()
      {
           foreach ($this->fixtures as $fixture) {
               $fixture->load($this->em);
               $this->logFixture($fixture);
           }
      }





      /**
       * @return string[]
      */
      public function getLogFixtures(): array
      {
          return $this->messages;
      }






      /**
       * @param Fixture $fixture
       * @return void
      */
      private function logFixture(Fixture $fixture)
      {
          $message = sprintf("Fixture %s successfully loaded.", get_class($fixture));

          $this->messages[] = $message;
      }
}