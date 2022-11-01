<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\MigratorCommand;

class MigrationMigrateCommand extends MigratorCommand
{

    /**
     * @var string
    */
    protected $name = 'migration:migrate';




    /**
     * @var string
    */
    protected $description = "Migrate all migrations to apply.";





    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->migrator->migrate()) {
            $output->writeln("Migrations successfully applied.");
            return Command::SUCCESS;
        }

        $output->writeln("No Migrations to apply.");
        return Command::SUCCESS;
    }
}