<?php
namespace Laventure\Foundation\Console\Commands\Database\Manager;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\DatabaseCommand;


class DatabaseImportCommand extends DatabaseCommand
{

    /**
     * @var string
     */
    protected $name = 'database:export';



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $database = $this->manager->getDatabase();

        $output->writeln("Must be to implements : ". __METHOD__);

        return Command::SUCCESS;
    }
}