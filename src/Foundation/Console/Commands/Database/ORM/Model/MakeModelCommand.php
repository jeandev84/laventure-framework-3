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
       protected $modelGenerator;





       /**
        * @param ModelGenerator $modelGenerator
       */
       public function __construct(ModelGenerator $modelGenerator)
       {
           parent::__construct('make:model');
           $this->modelGenerator = $modelGenerator;
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
             return $this->modelGenerator->generateModelClass($input->getArgument());
       }



       private function makeOptions(InputInterface $input)
       {
            if($options = $input->getOptions()) {
                 foreach ($options as $option) {

                 }
            }
       }




       // make : mfs
       private function makeMigrationFactorySeeder($model, $action)
       {
             return [
                 'm' => '',
                 'f' => '',
                 's' => ''
             ][$action];
       }

}