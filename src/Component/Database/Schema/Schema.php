<?php
namespace Laventure\Component\Database\Schema;


use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\BluePrintFactory;

/**
 * Schema
*/
class Schema
{

       /**
        * @var ConnectionInterface
       */
       protected $connection;





       /**
        * @param ConnectionInterface $connection
       */
       public function __construct(ConnectionInterface $connection)
       {
             $this->connection = $connection;
       }




       /**
        * Get connection
        *
        * @return ConnectionInterface
       */
       public function getConnection(): ConnectionInterface
       {
            return $this->connection;
       }




       /**
         * @param string $table
         * @param Closure $closure
         * @return bool
       */
       public function create(string $table, Closure $closure): bool
       {
             $blueprint = $this->make($table);

             $closure($blueprint);

             return $blueprint->createTable();
       }





       /**
        * @param string $table
        * @param Closure $closure
        * @return bool
       */
       public function table(string $table, Closure $closure): bool
       {
            if (! $this->has($table)) {
                 return false;
            }

            $blueprint = $this->make($table);

            $closure($blueprint);

            return $blueprint->updateTable();
       }





       /**
         * @param string $table
         * @return bool
       */
       public function drop(string $table): bool
       {
            return $this->make($table)->dropTable();
       }






       /**
        * @param string $table
        * @return bool
       */
       public function dropIfExists(string $table): bool
       {
            return $this->make($table)->dropIfExistsTable();
       }




       /**
        * @param string $table
        * @return bool
       */
       public function truncate(string $table): bool
       {
             return $this->make($table)->truncateTable();
       }

       
       
       
       

       /**
        * @param string $table
        * @return bool
       */
       public function truncateCascade(string $table): bool
       {
            return $this->make($table)->truncateTableCascade();
       }



       /**
        * Show table columns
        *
        * @param string $table
        * @return array
       */
       public function showColumns(string $table): array
       {
           return $this->make($table)->showTableColumns();
       }




       /**
        * Describe table
        *
        * @param $table
        * @return mixed
       */
       public function describeTable($table)
       {
           return $this->make($table)->describeTable();
       }



       /**
        * @return array
       */
       public function showTables(): array
       {
           return $this->connection->showTables();
       }





       /**
        * @param string $table
        * @return bool
       */
       public function has(string $table): bool
       {
             return $this->make($table)->existTable();
       }




       /**
        * Create BluePrint
        *
        * @param string $table
        * @return BluePrint
       */
       public function make(string $table): BluePrint
       {
            return BluePrintFactory::create($this->connection, $table);
       }
}