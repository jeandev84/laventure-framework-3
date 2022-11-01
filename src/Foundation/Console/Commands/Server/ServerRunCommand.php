<?php
namespace Laventure\Foundation\Console\Commands\Server;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Server\Common\ServerCommand;


class ServerRunCommand extends ServerCommand
{

      /**
       * @var string
      */
      protected $description = 'Lunch application server on the specific port.';



      public function __construct()
      {
          parent::__construct('server:run');
      }




      /**
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return int
      */
      public function execute(InputInterface $input, OutputInterface $output): int
      {
            return Command::SUCCESS;
      }
}