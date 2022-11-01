<?php
namespace Laventure\Component\Database\Schema\BluePrint\Types;

use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;

/**
 *
*/
class MysqlBluePrint extends BluePrint
{


    /**
     * @inheritDoc
    */
    public function createTable(): bool
    {
          /* SET foreign_key_checks=0; */

          $sql =  sprintf("CREATE TABLE IF NOT EXISTS `%s` (%s);",
               $this->getTable(),
               $this->printColumnsWithConstraints()
          );


          return $this->connection->exec($sql);
    }



    /**
     * @inheritDoc
    */
    public function updateTable(): bool
    {
         $sql = $this->printAlteredColumns();

         //dd($sql);

         return $this->connection->exec($sql);
    }



    /**
     * @inheritDoc
    */
    public function dropTable(): bool
    {
        // TODO: Implement dropTable() method.
    }



    /**
     * @inheritDoc
    */
    public function increments($name): Column
    {
         /* $column = $this->addColumn($name, 'INT', 11)->primaryKey()->extra(); */

         return $this->bigInteger($name)->primaryKey()->extra();
    }




    /**
     * @param $name
     * @param int $length
     * @return Column
    */
    public function integer($name, int $length = 11): Column
    {
         return $this->addColumn($name, 'INT', $length)
                     ->with('default', null);
    }



    /**
     * @param $name
     * @return Column
    */
    public function bigInteger($name): Column
    {
        return $this->addColumn($name, 'BIGINT');
    }





    /**
     * @param $name
     * @return Column
    */
    public function smallInteger($name): Column
    {
        return $this->addColumn($name, 'SMALLINT');
    }



    /**
     * @return array
    */
    public function showTableColumns(): array
    {
        $columnNames = [];

        foreach ($this->showInformationColumns() as $columnInfos) {
           $columnNames[] = $columnInfos['Field'];
        }

        return $columnNames;
    }




    /**
     * Show columns information as array
     *
     * @return array
    */
    public function showInformationColumns(): array
    {
        return $this->connection->statement('SHOW FULL COLUMNS FROM '. $this->getTable())
                                ->fetch()
                                ->asArray();
    }



    /**
     * @inheritDoc
    */
    public function describeTable()
    {
        // TODO: Implement describeTable() method.
    }
}