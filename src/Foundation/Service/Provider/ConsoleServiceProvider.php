<?php
namespace Laventure\Foundation\Service\Provider;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Console;
use Laventure\Component\Console\ConsoleInterface;
use Laventure\Component\Container\Provider\ServiceProvider;
use Laventure\Component\FileSystem\FileSystem;
use Laventure\Foundation\Console\Commands\Command\MakeCommand;
use Laventure\Foundation\Console\Commands\CommandStack;
use Laventure\Foundation\Console\Commands\Database\Manager\DatabaseCreateCommand;
use Laventure\Foundation\Console\Commands\Database\Manager\DatabaseDropCommand;
use Laventure\Foundation\Console\Commands\Database\Migration\MigrationInstallCommand;
use Laventure\Foundation\Console\Commands\Database\Migration\MigrationMakeCommand;
use Laventure\Foundation\Console\Commands\Database\Migration\MigrationMigrateCommand;
use Laventure\Foundation\Console\Commands\Database\Migration\MigrationResetCommand;
use Laventure\Foundation\Console\Commands\Database\Migration\MigrationRollbackCommand;
use Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures\LoadFixtureCommand;
use Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures\MakeFixtureCommand;
use Laventure\Foundation\Console\Commands\Database\ORM\Mapper\MakeEntityCommand;
use Laventure\Foundation\Console\Commands\Database\ORM\Model\MakeModelCommand;
use Laventure\Foundation\Console\Commands\Dotenv\GenerateEnvCommand;
use Laventure\Foundation\Console\Commands\Dotenv\GenerateSecretKeyCommand;
use Laventure\Foundation\Console\Commands\Http\MakeControllerCommand;
use Laventure\Foundation\Console\Commands\Server\ServerRunCommand;


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

               $console->addCommands($this->loadCommands($fileSystem));

               return $console;
         });
    }




    /**
     * @param FileSystem $fileSystem
     * @return Command[]
    */
    protected function loadCommands(FileSystem $fileSystem): array
    {
         $commands         = $this->getDefaultCommands();
         $commandNamespace =  config()->get("namespaces.commands");

         foreach ($this->getGeneratedCommands($fileSystem) as $command) {
             $commands[] =  "{$commandNamespace}\\{$command}";
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
          $commandPath = config()->get('paths.commands'). "/*Command.php";

          return  $fileSystem->collection($commandPath)->names();
    }





    /**
     * @return string[]
    */
    private function getDefaultCommands(): array
    {
        return [
            ServerRunCommand::class,
            GenerateEnvCommand::class,
            GenerateSecretKeyCommand::class,
            MakeCommand::class,
            DatabaseCreateCommand::class,
            DatabaseDropCommand::class,
            MigrationMakeCommand::class,
            MigrationInstallCommand::class,
            MigrationMigrateCommand::class,
            MigrationRollbackCommand::class,
            MigrationResetCommand::class,
            MakeModelCommand::class,
            MakeEntityCommand::class,
            MakeFixtureCommand::class,
            MakeControllerCommand::class,
            MakeFixtureCommand::class,
            LoadFixtureCommand::class
        ];
    }
}