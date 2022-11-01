<?php
namespace Laventure\Component\Database\Schema\BluePrint\Types;

use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;


/**
 *
*/
class PgsqlBluePrint extends BluePrint
{

    /**
     * @inheritDoc
    */
    public function createTable(): bool
    {
         // IF Table does not exist we'll create it.
    }




    /**
     * @inheritDoc
    */
    public function updateTable(): bool
    {
        // TODO: Implement updateTable() method.
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
         return $this->addColumn($name, 'SERIAL')->primaryKey();
    }




    /**
     * @param $name
     * @param int $length
     * @return Column
    */
    public function integer($name, int $length = 11): Column
    {
         return $this->addColumn($name, 'INTEGER');
    }




    /**
     * @param $name
     * @return Column
    */
    public function datetime($name): Column
    {
        return $this->addColumn($name, 'TIMESTAMP');
    }



    /**
     * @inheritDoc
    */
    public function bigInteger($name): Column
    {
        // TODO: Implement bigInteger() method.
    }


    public function smallInteger($name): Column
    {
        // TODO: Implement smallInteger() method.
    }


   public function showTableColumns(): array
   {
       // TODO: Implement getTableColumnNames() method.
   }


   public function showInformationColumns(): array
   {
       // TODO: Implement showInformationColumns() method.
   }

    /**
     * @inheritDoc
     */
    public function describeTable()
    {
        // TODO: Implement describeTable() method.
    }
}