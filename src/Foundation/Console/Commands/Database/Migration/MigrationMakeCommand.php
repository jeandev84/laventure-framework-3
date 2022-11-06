<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\InputArgument;
use Laventure\Component\Console\Input\InputParameter;
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
      protected $migrationGenerator;






      /**
       * @param MigrationGenerator $migrationGenerator
      */
      public function __construct(MigrationGenerator $migrationGenerator)
      {
          parent::__construct('make:migration');
          $this->migrationGenerator = $migrationGenerator;
      }





      protected function configure()
      {
           $this->addOption('table', 'Specify table name you want to create', '', [
               InputParameter::REQUIRED
           ]);
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

            // By default
            return $this->migrationGenerator->generateMigrationClass($tableName);
      }
}