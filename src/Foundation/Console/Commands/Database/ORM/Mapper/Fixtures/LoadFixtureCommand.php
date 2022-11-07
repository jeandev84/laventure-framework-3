<?php
namespace Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Fixtures\FixtureManager;




/**
 * @class LoadFixtureCommand
 *
 * @package Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures
 *
 * @author
*/
class LoadFixtureCommand extends Command
{

       /**
        * @var FixtureManager
       */
       protected $fixtureManager;




       /**
        * LoadFixtureCommand constructor
        *
       */
       public function __construct(FixtureManager $fixtureManager)
       {
            parent::__construct('fixtures:load');
            $this->fixtureManager = $fixtureManager;
       }





       /**
        * @param InputInterface $input
        * @param OutputInterface $output
        * @return int
       */
       public function execute(InputInterface $input, OutputInterface $output): int
       {

       }



//
//
//       /**
//        * @return Fixture[]
//       */
//       private function loadFixtures(): array
//       {
//           $fixturePath      = config()->get("namespaces.fixtures");
//           $fixtureNamespace = config()->get("paths.fixtures");
//
//           $fixtures = [];
//
//           foreach ($this->filesystem->collection("$fixturePath/*")->names() as $class) {
//               $class = $this->app->get("$fixtureNamespace\\$class");
//               if ($class instanceof Fixture) {
//                   $fixtures[] = $class;
//               }
//           }
//
//           return $fixtures;
//       }
}