<?php
namespace Laventure\Foundation\Console\Commands\Database\Manager;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Database\DatabaseCommand;


class DatabaseCreateCommand extends DatabaseCommand
{

       /**
        * @var string
       */
       protected $name = 'database:create';



       /**
        * @param InputInterface $input
        * @param OutputInterface $output
        * @return int
       */
       public function execute(InputInterface $input, OutputInterface $output): int
       {
            $database = $this->manager->getDatabase();

            if ($this->manager->existDatabase()) {
                 $output->writeln("Database '{$database}' already created!");
                 return Command::SUCCESS;
            }

            if ($this->manager->databaseCreated()) {
                $output->writeln("Database '{$database}' successfully created!");
            }

            return Command::SUCCESS;
        }

}