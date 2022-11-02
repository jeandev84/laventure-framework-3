<?php
namespace Laventure\Foundation\Console\Commands\Database\ORM\Mapper\Fixtures;

use Laventure\Component\Console\Command\Command;

class LoadFixtureCommand extends Command
{

       /**
        * LoadFixtureCommand constructor
       */
       public function __construct()
       {
           parent::__construct('load:fixtures');
       }
}