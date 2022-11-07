<?php
namespace Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\ORM\Mapper\FixtureGenerator;


/**
 * @class MakeFixtureCommand
*/
class MakeFixtureCommand extends Command
{


       /**
        * @var FixtureGenerator
       */
       protected $generator;




       /**
        * @param FixtureGenerator $generator
       */
       public function __construct(FixtureGenerator $generator)
       {
            parent::__construct('make:fixture');
            $this->generator = $generator;
       }






       /**
        * @param InputInterface $input
        * @param OutputInterface $output
        * @return int
       */
       public function execute(InputInterface $input, OutputInterface $output): int
       {
           if ($path = $this->make($input)) {
                $output->success("Fixture '{$path}' successfully generated.");
           }

           return Command::SUCCESS;
       }






       /**
        * @param InputInterface $input
        * @return string|null
       */
       private function make(InputInterface $input): ?string
       {
            return $this->generator->generateFixture($input->getArgument());
       }
}