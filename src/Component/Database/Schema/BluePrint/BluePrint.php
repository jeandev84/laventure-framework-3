<?php
namespace Laventure\Component\Database\Schema\BluePrint;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;
use Laventure\Component\Database\Schema\BluePrint\Column\ColumnCollection;
use Laventure\Component\Database\Schema\BluePrint\Keys\ForeignKey;

/**
 *
*/
abstract class BluePrint
{

      /**
       * @var ConnectionInterface
      */
      protected $connection;




      /**
       * @var string
      */
      protected $table;




      /**
       * @var ColumnCollection
      */
      protected $columns;




      /**
       * @var array
      */
      protected $foreignKeys = [];



      /**
       * @var array
      */
      protected $primaryKeys = [];




      /**
       * @var array
      */
      protected $indexes = [];




      /**
       * @var array
      */
      protected $uniques = [];



      /**
       * @var array
      */
      protected $altered = [];




      /**
       * @var Column[]
      */
      protected $modifyColumns = [];


      /**
       * @var string[]
      */
      protected $dropColumns = [];



      /**
       * @var array
      */
      protected $renameColumns = [];



      /**
       * @param ConnectionInterface $connection
       * @param string $table
      */
      public function __construct(ConnectionInterface $connection, string $table)
      {
            $this->connection = $connection;
            $this->table      = $table;
            $this->columns    = new ColumnCollection();
      }





      /**
       * @return string
      */
      public function getTable(): string
      {
            return $this->connection->prepareTable($this->table);
      }




      /**
       * @param string $name
       * @param string $type
       * @param int|null $length
       * @param null $default
       * @return Column
      */
      public function addColumn(string $name, string $type, int $length = null, $default = null): Column
      {
            $column = new Column();
            $column->name($name)
                   ->type($type, $length);

            if ($default) {
                $column->default($default);
            }

            return $this->columns->addColumn($name, $column);
      }



      /**
       * @param string $name
       * @return false|Column
      */
      public function modifyColumn(string $name): Column
      {
            if (! in_array($name, $this->showTableColumns())) {
                 return false;
            }

            $column = new Column();
            $column->name($name);

            return $this->modifyColumns[$name] = $column;
      }





      /**
       * @param string $column
       * @return $this
      */
      public function dropColumn(string $column): self
      {
           if (in_array($column, $this->showTableColumns())) {
               $this->dropColumns[$column] = "DROP COLUMN {$column}";
           }

           return $this;
      }




      /**
       * @param string $column
       * @param string $to
       * @return $this
      */
      public function renameColumn(string $column, string $to): self
      {
           if (in_array($column, $this->showTableColumns())) {
               $this->renameColumns[$column] = "RENAME COLUMN {$column} TO $to";
           }

           return $this;
      }




      /**
       * @return array
      */
      protected function getDropColumns(): array
      {
           return $this->dropColumns;
      }



      /**
       * @return Column[]
      */
      protected function getModifyColumns(): array
      {
          return $this->modifyColumns;
      }




      /**
       * @return array
      */
      protected function getRenameColumns(): array
      {
           return $this->renameColumns;
      }

      /**
       * @return Column
      */
      public function id(): Column
      {
           return $this->increments('id');
      }



      /**
       * @param $name
       * @param int $length
       * @return Column
      */
      public function string($name, int $length = 255): Column
      {
           return $this->addColumn($name, 'VARCHAR', $length);
      }




      /**
       * @param $name
       * @return Column
      */
      public function text($name): Column
      {
           return $this->addColumn($name, 'TEXT');
      }




      /**
       * @param $name
       * @return Column
      */
      public function datetime($name): Column
      {
           return $this->addColumn($name, 'DATETIME');
      }




      /**
       * @return void
      */
      public function timestamps()
      {
           $this->datetime('created_at');
           $this->datetime('updated_at');
      }




      /**
       * @return Column
      */
      public function softDeletes(): Column
      {
          return $this->boolean('deleted_at');
      }




      /**
       * @param $columns
       * @return $this
      */
      public function primary($columns): self
      {
          $this->primaryKeys[] = "PRIMARY (". implode(", ", (array) $columns) . ")";

          return $this;
      }




      /**
       * @param array|string $indexes
       * @return $this
      */
      public function index($indexes): self
      {
           $columns = implode(', ', (array) $indexes);

           $this->indexes[] = "INDEX({$columns})";

           return $this;
      }





      /**
       * @param $key
       * @return ForeignKey
      */
      public function foreign($key): ForeignKey
      {
           $foreignKey = new ForeignKey($key, $this->table);

           return $this->foreignKeys[] = $foreignKey;
      }



      /**
       * @return ForeignKey
      */
      public function foreignId(): ForeignKey
      {
           return $this->foreign('id');
      }





      /**
       * @param array|string $columns
       * @return $this
      */
      public function unique($columns): self
      {
            $uniques = implode(',', (array) $columns);

            $this->uniques[] = "UNIQUE({$uniques})";

            return $this;
      }




      /**
       * @param $name
       * @return Column
      */
      public function boolean($name): Column
      {
           return $this->addColumn($name, 'BOOLEAN');
      }




      /**
       * @return mixed
      */
      public function dropTable()
      {
           return $this->connection->exec(
               sprintf('DROP TABLE %s;', $this->getTable())
           );
      }





      /**
       * Drop table
       *
       * @return bool
      */
      public function dropIfExistsTable(): bool
      {
           return $this->connection->exec(
               sprintf('DROP TABLE IF EXISTS %s;', $this->getTable())
           );
      }





      /**
       * @return mixed
      */
      public function truncateTable()
      {
          return $this->connection->exec(
              sprintf('TRUNCATE TABLE %s;', $this->getTable())
          );
      }




      /**
       * @return bool
      */
      public function truncateTableCascade(): bool
      {
           return $this->connection->exec(
               sprintf('TRUNCATE TABLE CASCADE %s;', $this->getTable())
           );
      }




      /**
       * Determine if the given column name exist in table
       *
       * @param $column
       * @return bool
      */
      public function existColumn($column): bool
      {
           return in_array($column, $this->showTableColumns());
      }





      /**
       * Determine if the current table name exist.
       *
       * @return bool
      */
      public function existTable(): bool
      {
            return in_array($this->getTable(), $this->showTables());
      }





      /**
       * @return array
      */
      public function showTables(): array
      {
           return $this->connection->showTables();
      }




      /**
       * Show table columns
       *
       * @return array
      */
      abstract public function showTableColumns(): array;





      /**
       * Describe table
       *
       * @return mixed
      */
      abstract public function describeTable();




      /**
       * @param $name
       * @return Column
      */
      abstract public function increments($name): Column;





      /**
       * @param $name
       * @param int $length
       * @return Column
      */
      abstract public function integer($name, int $length = 11): Column;




      /**
       * @param $name
       * @return Column
      */
      abstract public function smallInteger($name): Column;





      /**
       * @param $name
       * @return Column
      */
      abstract public function bigInteger($name): Column;




      /**
       * Create table
       *
       * @return bool
      */
      abstract public function createTable(): bool;




      /**
       * Update or Modify table
       *
       * @return bool
      */
      abstract public function updateTable(): bool;




      /**
       * @return array
      */
      abstract public function showInformationColumns(): array;





      /**
       * @return string
      */
      protected function printPrimaryKeys(): string
      {
          return join(", \n", $this->primaryKeys);
      }



     /**
      * @return string
     */
     protected function printForeignKeys(): string
     {
         return join(", \n", $this->foreignKeys);
     }






    /**
     * @return string
    */
    protected function printUniqueColumns(): string
    {
          return join(", \n", $this->uniques);
    }




    /**
     * @return string
    */
    protected function printIndexes(): string
    {
        return join(", \n", $this->indexes);
    }




    /**
     * @return string
    */
    protected function printColumnsWithConstraints(): string
    {
        return implode(", \n", array_filter([
            $this->columns,
            $this->printPrimaryKeys(),
            $this->printIndexes(),
            $this->printUniqueColumns(),
            $this->printForeignKeys()
        ]));
    }




    /**
     * @return string
    */
    protected function printAlteredColumns(): string
    {
        foreach ($this->modifyColumns as $column) {
            $this->modifyColumns[$column->getName()] = "MODIFY COLUMN {$column}";
            $this->columns->addColumn($column->getName(), $column);
        }

        $commands = array_filter([
              $this->getNewColumns(),
              $this->getDropColumns(),
              $this->getModifyColumns(),
              $this->getRenameColumns()
        ]);

        $altered   = ["ALTER TABLE {$this->getTable()}"];
        $altered[] = PHP_EOL;

        $collections = [];

        foreach ($commands as $commandCollection) {
             $collections[] = implode(", ". PHP_EOL, array_values($commandCollection));
        }

        $altered[] = implode(", ". PHP_EOL, $collections);
        $altered[] = PHP_EOL;

        return implode($altered).";";
    }



    /**
     * @return array
     */
    protected function getNewColumns(): array
    {
         $columns = [];

         if($newColumns = $this->columns->diff($this->showTableColumns())) {
             foreach ($newColumns as $column) {
                $columns[$column->getName()] = "ADD COLUMN {$column}";
             }
         }

         return $columns;
    }


}