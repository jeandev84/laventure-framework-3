<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Commands;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


class Delete extends SqlBuilder
{

    /**
     * @param string $table
    */
    public function __construct(string $table)
    {
          parent::__construct($table);
    }


    
    /**
     * @return string
    */
    protected function openSQL(): string
    {
         return sprintf("DELETE FROM %s", $this->getTable());
    }
}