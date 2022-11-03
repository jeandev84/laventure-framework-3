<?php
namespace Laventure\Foundation\Console\Commands\Database\ORM\Mapper;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\ORM\Mapper\EntityGenerator;
use Laventure\Foundation\Service\Generator\ORM\Mapper\EntityRepositoryGenerator;


class MakeEntityCommand extends Command
{


      /**
       * @var EntityGenerator
      */
      protected $entityGenerator;


      /**
       * @var EntityRepositoryGenerator
      */
      protected $repositoryGenerator;





      /**
       * @param EntityGenerator $webGenerator
       * @param EntityRepositoryGenerator $repositoryGenerator
      */
      public function __construct(EntityGenerator $webGenerator, EntityRepositoryGenerator $repositoryGenerator)
      {
           parent::__construct('make:entity');
           $this->entityGenerator     = $webGenerator;
           $this->repositoryGenerator = $repositoryGenerator;
      }





     /**
      * Example:
      *  $ php console make:entity Foo
      *  $ php console make:entity Api/V1/User
      *
      *
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return int
     */
     public function execute(InputInterface $input, OutputInterface $output): int
     {
         foreach ($this->make($input) as $name => $path) {
              if ($path) {
                  $output->success("{$name} '{$path}' successfully generated.");
              }
         }

         return Command::SUCCESS;
     }





     /**
      * @param InputInterface $input
      * @return array
     */
     public function make(InputInterface $input): array
     {
          $name = $input->getArgument();

          return [
              'Entity'      => $this->generateEntityClass($name),
              'Repository'  => $this->generateRepository($name)
          ];
     }




     /**
      * @param $name
      * @return string|null
     */
     protected function generateEntityClass($name): ?string
     {
           return $this->entityGenerator->generateEntityClass($name);
     }




     /**
      * @param $name
      * @return string|null
     */
     protected function generateRepository($name): ?string
     {
           return $this->repositoryGenerator->generateRepository($name);
     }
}