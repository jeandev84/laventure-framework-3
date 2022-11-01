<?php
namespace Laventure\Foundation\Console\Commands\Database\Manager;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\DatabaseCommand;


class DatabaseDropCommand extends DatabaseCommand
{

    /**
     * @var string
     */
    protected $name = 'database:drop';





    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $database = $this->manager->getDatabase();

        if ($this->manager->databaseDropped()) {
            $output->writeln("Database '{$database}' successfully dropped!");
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

}