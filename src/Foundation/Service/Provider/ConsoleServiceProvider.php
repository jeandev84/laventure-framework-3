<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Console;
use Laventure\Component\Console\ConsoleInterface;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\FileSystem\FileSystem;
use Laventure\Foundation\Console\Commands\CommandStack;


/**
 *
*/
class ConsoleServiceProvider extends ServiceProvider
{

    protected $provides = [
        Console::class => ['console', ConsoleInterface::class]
    ];



    /**
     * @inheritDoc
    */
    public function register()
    {
         $this->app->singleton(Console::class, function (FileSystem $fileSystem) {

               $console = $this->app->make(Console::class);

               $console->addCommands( $this->loadCommands($fileSystem));

               return $console;
         });
    }




    /**
     * @param FileSystem $fileSystem
     * @return Command[]
    */
    protected function loadCommands(FileSystem $fileSystem): array
    {
         $commands = CommandStack::getDefaultCommands();

         foreach ($this->getGeneratedCommands($fileSystem) as $command) {
             $commands[] = "App\\Console\\Commands\\{$command}";
         }

         $stack = [];

         foreach ($commands as $command) {
              $command = $this->app->get($command);
              if ($command instanceof Command) {
                  $stack[] = $command;
              }
         }

         return $stack;
    }





    /**
     * @param FileSystem $fileSystem
     * @return array
    */
    private function getGeneratedCommands(FileSystem $fileSystem): array
    {
        return  $fileSystem->collection('/app/Console/Commands/*Command.php')->names();
    }
}