<?php
namespace Laventure\Component\Console;

use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;

class Application extends Console
{

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function run(InputInterface $input, OutputInterface $output): int
    {
          // Header + Footer
          return parent::run($input, $output);
    }
}