<?php
namespace Laventure\Foundation\Facade\Database;

use Laventure\Component\Container\Facade\Facade;
use Laventure\Component\Database\ORM\Manager;


/**
 * DB facade
*/
class DB extends Facade
{

    /**
     * @inheritdoc
    */
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}