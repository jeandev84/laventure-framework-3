<?php
namespace Laventure\Component\Console\Command\Defaults;

use Laventure\Component\Console\Command\Command;


/**
 * HelpCommand
*/
class HelpCommand extends Command
{

     /**
      * HelpCommand constructor
     */
     public function __construct()
     {
         parent::__construct('help');
     }
}