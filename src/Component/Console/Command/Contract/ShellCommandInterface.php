<?php
namespace Laventure\Component\Console\Command\Contract;

interface ShellCommandInterface
{
      /**
       * @param $command
       * @return mixed
      */
      public function exec($command);
}