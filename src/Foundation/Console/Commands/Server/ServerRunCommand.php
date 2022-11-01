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
       * Example:
       *  $ php console server:run --host=http://demo.com
       *  $ php console server:run --port=8001
       *  $ php console server:run --port=8001 --no-exception (display_errors=0)
       *
       *
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return int
      */
      public function execute(InputInterface $input, OutputInterface $output): int
      {
            $output->write($this->exec($this->makeCommand($input), $this->getHeaderMessage($input)));

            return Command::SUCCESS;
      }





      /**
       * @param InputInterface $input
       * @return array
      */
      protected function getHeaderMessage(InputInterface $input): array
      {
            $port = $input->getOption('port');
            $host = $input->getOption('host');

            if ($host && stripos($host, '127.0.0.1:') === false) {
                return [];
            }

            return [
                sprintf("Server listen on the port :%s", $this->port($port)),
                sprintf("Open to your browser next link %s", $this->link($port))
            ];

      }





      /**
       * @param InputInterface $input
       * @return string
      */
      protected function makeCommand(InputInterface $input): string
      {
           $host = $this->host();

           if ($input->hasOption('host')) {
               $host = $input->getOption('host');
           }

           if (stripos($host, '127.0.0.1:') !== false) {

                [$ip, $port] = explode(':', $host, 2);

                if ($input->hasOption('port')) {
                     $port = $input->getOption('port');
                }

                $host = implode(":", [$ip, $port]);
           }

           $errorStatus = $input->hasFlag('no-exception') ? 0 : 1;

           return $this->printCommand($host, array_filter([
               "-display_errors={$errorStatus}"
           ]));
      }




      /**
       * @param string $host
       * @param array $options
       * @return string
      */
      protected function printCommand(string $host, array $options = []): string
      {
          return trim(sprintf("php -S %s -t public %s", $host, join(' ', $options)));
      }
}