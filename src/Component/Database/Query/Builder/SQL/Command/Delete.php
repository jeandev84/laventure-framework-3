<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Command;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


class Delete extends SqlBuilder
{
    
    /**
     * @return string
    */
    protected function openQuery(): string
    {
         return sprintf("DELETE FROM %s", $this->getTable());
    }
}