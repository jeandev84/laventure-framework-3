<?php
namespace Laventure\Component\Console\Command;


use Laventure\Component\Console\Command\Contract\ShellCommandInterface;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;

/**
 * @class ShellCommand
*/
class ShellCommand extends Command implements ShellCommandInterface
{
      /**
       * @param $command
       * @param array $headers
       * @return false|string|null
      */
      public function exec($command, array $headers = [])
      {
           if ($headers) {
               print(join(PHP_EOL, $headers). "\n\n");
           }

           return shell_exec($command);
      }
}