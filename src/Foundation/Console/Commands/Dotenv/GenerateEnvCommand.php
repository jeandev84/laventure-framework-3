<?php
namespace Laventure\Foundation\Console\Commands\Dotenv;

use Laventure\Component\Console\Command\Command;

class GenerateEnvCommand extends Command
{

      public function __construct()
      {
          parent::__construct('generate:env');
      }
}