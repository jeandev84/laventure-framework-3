<?php
namespace Laventure\Foundation\Console\Commands\Dotenv;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Dotenv\Contract\EnvCommand;
use Laventure\Foundation\Service\Generator\Dotenv\EnvGenerator;


class GenerateEnvCommand extends EnvCommand
{

      /**
       * @param EnvGenerator $envGenerator
      */
      public function __construct(EnvGenerator $envGenerator)
      {
          parent::__construct($envGenerator, 'env:gen');
      }





      /**
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return int
      */
      public function execute(InputInterface $input, OutputInterface $output): int
      {
            $output->success("Generated file [ .env ]");

            return Command::SUCCESS;
      }
}