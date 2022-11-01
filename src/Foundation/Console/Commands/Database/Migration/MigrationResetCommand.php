<?php
namespace Laventure\Foundation\Console\Commands\Database\Migration;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\MigratorCommand;


class MigrationResetCommand extends MigratorCommand
{

    /**
     * @var string
    */
    protected $name = 'migration:reset';




    /**
     * @var string
    */
    protected $description = "reset all applied migrations .";





    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! $this->migrator->reset()) {
            $output->writeln("Migrations already reset.");
            return Command::FAILURE;
        }

        $output->writeln("Migrations successfully reset.");
        return Command::SUCCESS;
    }
}