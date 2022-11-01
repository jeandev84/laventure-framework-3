<?php
namespace Laventure\Component\Database\Schema\BluePrint\Types;

use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;


/**
 *
*/
class OracleBluePrint extends BluePrint
{

    /**
     * @inheritDoc
     */
    public function showTableColumns(): array
    {
        // TODO: Implement showTableColumns() method.
    }

    /**
     * @inheritDoc
     */
    public function describeTable()
    {
        // TODO: Implement describeTable() method.
    }

    /**
     * @inheritDoc
     */
    public function increments($name): Column
    {
        // TODO: Implement increments() method.
    }

    /**
     * @inheritDoc
     */
    public function integer($name, int $length = 11): Column
    {
        // TODO: Implement integer() method.
    }

    /**
     * @inheritDoc
     */
    public function smallInteger($name): Column
    {
        // TODO: Implement smallInteger() method.
    }

    /**
     * @inheritDoc
     */
    public function bigInteger($name): Column
    {
        // TODO: Implement bigInteger() method.
    }

    /**
     * @inheritDoc
     */
    public function createTable(): bool
    {
        // TODO: Implement createTable() method.
    }

    /**
     * @inheritDoc
     */
    public function updateTable(): bool
    {
        // TODO: Implement alterTable() method.
    }

    /**
     * @inheritDoc
     */
    public function showInformationColumns(): array
    {
        // TODO: Implement showInformationColumns() method.
    }
}