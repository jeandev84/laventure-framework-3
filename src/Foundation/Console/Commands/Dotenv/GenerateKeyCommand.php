<?php
namespace Laventure\Foundation\Console\Commands\Dotenv;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;


class GenerateKeyCommand extends Command
{

      public function __construct()
      {
          parent::__construct('gen:key');
      }


      public function execute(InputInterface $input, OutputInterface $output): int
      {
          return Command::SUCCESS;
      }
}