<?php
namespace Laventure\Foundation\Console\Commands\Database;


use Laventure\Component\Console\Command\Command;
use Laventure\Component\Database\Migration\Migrator;


/**
 * MigratorCommand
*/
abstract class MigratorCommand extends Command
{

      /**
       * @var Migrator
      */
      protected $migrator;




      /**
       * @param Migrator $migrator
       * @param $name
      */
      public function __construct(Migrator $migrator, $name = null)
      {
          parent::__construct($name);
          $this->migrator = $migrator;
      }
}