<?php
namespace Laventure\Foundation\Console\Commands\Command;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\Command\CommandGenerator;


/**
 * MakeCommand
*/
class MakeCommand extends Command
{


      /**
       * @var CommandGenerator
      */
      protected $generator;





      /**
       * @param CommandGenerator $controllerGenerator
      */
      public function __construct(CommandGenerator $controllerGenerator)
      {
            parent::__construct('make:command');
            $this->generator = $controllerGenerator;
      }






      /**
       * @return void
      */
      protected function configure()
      {
           $this->description('Generate new command.');
      }






      /**
       * Example:
       *
       *  $ php console make:command demo              ( given command default name. )
       *  $ php console make:command generate:password ( given command name. )
       *
       *
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return int
      */
      public function execute(InputInterface $input, OutputInterface $output): int
      {
            if($filename = $this->make($input->getArgument())) {
                 $output->success("Command $filename generated successfully.");
            }

            return Command::SUCCESS;
      }





      /**
       * @param $name
       * @return string|null
      */
      protected function make($name): ?string
      {
           return $this->generator->generateCommandClass($name);
      }
}