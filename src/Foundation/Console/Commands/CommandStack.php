<?php
namespace Laventure\Foundation\Console\Commands;

use Laventure\Foundation\Console\Commands\Command\MakeCommand;
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
use Laventure\Foundation\Console\Commands\Dotenv\GenerateKeyCommand;
use Laventure\Foundation\Console\Commands\Http\MakeControllerCommand;
use Laventure\Foundation\Console\Commands\Server\ServerRunCommand;

class CommandStack
{


     /**
      * @return string[]
     */
     public static function getDefaultCommands(): array
     {
          return [
              ServerRunCommand::class,
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
              LoadFixtureCommand::class,
              GenerateEnvCommand::class,
              GenerateKeyCommand::class,
          ];
     }
}