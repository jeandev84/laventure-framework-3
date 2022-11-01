<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Service\Generator\Migration\MigrationGenerator;


class MigrationMakeCommand extends Command
{

      /**
       * @var string
      */
      protected $name = 'make:migration';




      /**
       * @var string
      */
      protected $description = 'Generate a new migration file.';





      /**
       * @var MigrationGenerator
      */
      protected $generator;






      /**
       * @param MigrationGenerator $generator
      */
      public function __construct(MigrationGenerator $generator)
      {
          parent::__construct('make:migration');
          $this->generator = $generator;
      }






      /**
       * Example :
       *
       * todo flag -orm (dynamically) get type orm from config and get path
       *
       *  ORM Mapper
       *  $ php console make:migration --table=users --entity=App\Entity\User -orm=mapper,model
       *  $ php console make:migration --table=demo --entity=App\Entity\Demo
       *
       * ORM Model
       *  $ php console make:migration create_users_table --table=users --model=App\Model\User
       *
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return int
      */
      public function execute(InputInterface $input, OutputInterface $output): int
      {
          if($path = $this->make($input)) {
              $output->success("Migration file '{$path}' successfully generated.");
          }

          return Command::SUCCESS;
      }




      /**
       * @param InputInterface $input
       * @return string|null
      */
      protected function make(InputInterface $input): ?string
      {
            $tableName  = $input->getOption('table');
            $entityName = $input->getOption('entity');
            $modelName  = $input->getOption('model');

            $credentials = compact('tableName');


            // By default
            return $this->generator->generateMapperMigrationClass($credentials);
      }
}