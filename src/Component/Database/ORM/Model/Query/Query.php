<?php
namespace Laventure\Component\Database\ORM\Model\Query;

use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Manager;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\QueryBuilder;


/**
 * Query
*/
class Query
{

       /**
        * @var string
       */
       protected $table;



       /**
        * @var string
       */
       protected $class;



       /**
        * @var string
       */
       protected $connection;




       /**
        * @var Manager
       */
       protected $manager;





       /**
        * @param string $table
        * @param string $class
       */
       public function __construct(string $table, string $class)
       {
             $this->table      = $table;
             $this->class      = $class;
             $this->manager    = Manager::make();
             $this->connection = $this->manager->getConnectionName();
       }



       /**
        * @param string $name
        * @return void
       */
       public function connection(string $name)
       {
            $this->connection = $name;
       }




       /**
        * @return QueryBuilder
       */
       public function make(): QueryBuilder
       {
           $pdoConnection = $this->manager->pdoConnection($this->connection);
           $queryBuilder  = $this->manager->makeQB($pdoConnection, $this->table);
           $queryBuilder->classMap($this->class);
           return $queryBuilder;
       }
}