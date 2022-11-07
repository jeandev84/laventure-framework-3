<?php
namespace Laventure\Foundation\Console\Commands\Dotenv\Contract;

use Laventure\Component\Console\Command\Command;
use Laventure\Foundation\Service\Generator\Dotenv\EnvGenerator;


/**
 * @class EnvCommand
 *
 * @package Laventure\Foundation\Console\Commands\Dotenv\Contract
 *
 * @author
*/
abstract class EnvCommand extends Command
{

       /**
        * @var EnvGenerator
       */
       protected $envGenerator;





       /**
        * @param EnvGenerator $envGenerator
        * @param $name
       */
       public function __construct(EnvGenerator $envGenerator, $name = null)
       {
            parent::__construct($name);
            $this->envGenerator = $envGenerator;
       }
}