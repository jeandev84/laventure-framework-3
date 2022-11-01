<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\MigratorCommand;


class MigrationRollbackCommand extends MigratorCommand
{

      /**
       * @var string
      */
      protected $name = 'migration:rollback';




      /**
       * @var string
      */
      protected $description = "rollback all migrations .";






     /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return int
     */
     public function execute(InputInterface $input, OutputInterface $output): int
     {
        if (! $this->migrator->rollback()) {
            $output->writeln("Something went wrong during rolling back migrations.");
            return Command::FAILURE;
        }

        $output->writeln("Migrations successfully rollback.");
        return Command::SUCCESS;
     }
}