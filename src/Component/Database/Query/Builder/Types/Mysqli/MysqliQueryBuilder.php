<?php
namespace Laventure\Component\Database\Query\Builder\Types\Mysqli;

use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\Types\QueryBuilderContract;


/**
 * @class MysqliQueryBuilder
 *
 * @package Laventure\Component\Database\Query\Builder\Types\Mysqli
 *
 * @author
*/
class MysqliQueryBuilder extends QueryBuilderContract
{

    /**
     * @inheritDoc
    */
    protected function resolveWheres(SqlBuilder $builder)
    {
        if (! empty($this->wheres)) {
            foreach ($this->wheres as $column => $value) {
                $builder->where("$column = '{$value}'");
            }
        }

        return $builder;
    }
}