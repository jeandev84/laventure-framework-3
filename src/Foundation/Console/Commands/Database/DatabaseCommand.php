<?php
namespace Laventure\Foundation\Console\Commands\Database;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Database\ORM\Manager;


/**
 * DatabaseCommand
*/
abstract class DatabaseCommand extends Command
{

    /**
     * @var Manager
    */
    protected $manager;





    /**
     * @param Manager $fixtureManager
     * @param null $name
    */
    public function __construct(Manager $fixtureManager, $name = null)
    {
        parent::__construct($name);
        $this->manager = $fixtureManager;
    }


}