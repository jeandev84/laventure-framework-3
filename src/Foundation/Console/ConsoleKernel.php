<?php
namespace Laventure\Foundation\Console;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Console;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Contract\Console\Kernel;
use Laventure\Foundation\Application;


/**
 * ConsoleKernel
*/
abstract class ConsoleKernel implements Kernel
{


     /**
      * @var Application
     */
     protected $app;




     /**
      * @var Console
     */
     protected $console;






     /**
      * store commands
      *
      * @var Command[]
     */
     protected $commands = [];





     /**
      * ConsoleKernel
      *
      * @param Application $app
      * @param Console $console
     */
     public function __construct(Application $app, Console $console)
     {
           $this->app = $app;
           $console->addCommands($this->loadCommands($app));
           $this->console = $console;
     }




     /**
      * @inheritDoc
     */
     public function handle(InputInterface $input, OutputInterface $output)
     {

         try {

             return $this->console->run($input, $output);

         } catch (\Exception $e) {

               // console logger
               echo "ConsoleLogger\n";
               exit($e->getMessage()."\n");
         }
     }






     /**
      * @inheritDoc
     */
     public function terminate(InputInterface $input, $status)
     {
           $this->console->terminate($input, $status);
     }




     /**
      * @return Command[]
     */
     private function loadCommands(Application $app): array
     {
          $commands = [];

          foreach ($this->getCommands() as $command) {
               $command = $app->get($command);
               if ($command instanceof Command) {
                   $commands[] = $command;
               }
          }

          return $commands;
     }




     /**
      * @return string[]
     */
     private function getCommands(): array
     {
           return $this->commands;
     }
}