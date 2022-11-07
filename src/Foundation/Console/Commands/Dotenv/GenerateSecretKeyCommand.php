<?php
namespace Laventure\Foundation\Console\Commands\Dotenv;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Foundation\Console\Commands\Dotenv\Contract\EnvCommand;
use Laventure\Foundation\Service\Generator\Dotenv\EnvGenerator;


class GenerateSecretKeyCommand extends EnvCommand
{

        /**
         * @param EnvGenerator $envGenerator
        */
        public function __construct(EnvGenerator $envGenerator)
        {
             parent::__construct($envGenerator, 'env:secret');
        }





        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return int
        */
        public function execute(InputInterface $input, OutputInterface $output): int
        {
             if ($this->envGenerator->generateKey("APP_SECRET", $secret = $this->generateSecretKey())) {
                 $output->success("New secret key '{$secret}' has been generated successfully in .env");
             }

             return Command::SUCCESS;
        }




        /**
         * @return string
        */
        private function generateSecretKey(): string
        {
              return md5(app_name() . uniqid(rand(), true));
        }
}