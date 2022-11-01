<?php
namespace Laventure\Foundation\Console\Commands\Http;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\Http\ControllerGenerator;


class MakeControllerCommand extends Command
{


     /**
      * @var ControllerGenerator
     */
     protected $generator;





     /**
      * @param ControllerGenerator $generator
     */
     public function __construct(ControllerGenerator $generator)
     {
           parent::__construct('make:controller');
           $this->generator = $generator;
     }






     /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return int
     */
     public function execute(InputInterface $input, OutputInterface $output): int
     {
         if ($path = $this->generateController($input)) {
              $output->success("Controller '$path' successfully generated.");
         }

         return Command::SUCCESS;
     }






     /**
      * @param InputInterface $input
      * @return string
     */
     protected function generateController(InputInterface $input): string
     {
           return $this->generator->generateController([
               'DummyClass'   => $input->getArgument(),
               // 'DummyActions' => ['index', 'show', 'create', 'update', 'destroy']
           ]);
     }
}