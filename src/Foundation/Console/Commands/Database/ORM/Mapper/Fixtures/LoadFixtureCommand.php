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
            if ($fixtures = $this->fixtureManager->loadFixtures()) {
                 foreach ($fixtures as $fixture) {
                      $output->success(sprintf("Fixture '%s' successfully loaded.", $fixture));
                 }
            }

            return Command::SUCCESS;
       }
}