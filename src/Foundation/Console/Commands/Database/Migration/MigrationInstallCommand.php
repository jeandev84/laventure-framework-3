<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\MigratorCommand;


class MigrationInstallCommand extends MigratorCommand
{

    /**
     * @var string
    */
    protected $name = 'migration:install';




    /**
     * @var string
    */
    protected $description = "Create a migration version table.";




    /**
     *
     * Example :
     *  $ php console migration:install
     *
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $tableName = $this->migrator->getTable();

        if ($this->migrator->existTable()) {
            $output->writeln("Migrations version table '{$tableName}' already installed.");
        } elseif ($this->migrator->install()){
            $output->writeln("Migrations version table '{$tableName}' successfully installed.");
        }

        return Command::SUCCESS;
    }
}