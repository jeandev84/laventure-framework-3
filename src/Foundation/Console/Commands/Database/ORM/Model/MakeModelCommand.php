<?php
namespace Laventure\Foundation\Console\Commands\Database\ORM\Model;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\ORM\Model\ModelGenerator;


/**
 * MakeModelCommand
*/
class MakeModelCommand extends Command
{


       /**
        * @var ModelGenerator
       */
       protected $generator;




       /**
        * @param ModelGenerator $controllerGenerator
       */
       public function __construct(ModelGenerator $controllerGenerator)
       {
           parent::__construct('make:model');
           $this->generator = $controllerGenerator;
       }





       /**
        * @param InputInterface $input
        * @param OutputInterface $output
        * @return int
       */
       public function execute(InputInterface $input, OutputInterface $output): int
       {
           if($path = $this->make($input)) {
               $output->success("Model '{$path}' successfully generated.");
           }

           return Command::SUCCESS;
       }





       /**
        * @param InputInterface $input
        * @return string|null
       */
       protected function make(InputInterface $input): ?string
       {
             $credentials = ['DummyClass' => $input->getArgument()];

             return $this->generator->generateModelClass($credentials);
       }

}