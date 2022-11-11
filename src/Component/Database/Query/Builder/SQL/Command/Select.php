<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Command;


use Laventure\Component\Database\Connection\Query\QueryHydrateInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 * Select
*/
class Select extends SqlBuilder
{


       /**
        * @var bool
       */
       protected $distinct = false;




       /**
        * @var string[]
       */
       protected $selects;



       /**
         * @var string[]
       */
       protected $from = [];




       /**
         * @var string[]
       */
       protected $orderBy = [];



       /**
        * @var string
       */
       protected $joins = [];



       /**
        * @var string
       */
       protected $groupBy = [];




       /**
        * @var string[]
       */
       protected $having = [];




       /**
        * @param array $selects
        * @param string $table
       */
       public function __construct(array $selects, string $table)
       {
            parent::__construct($table);

            $this->selects = $selects;
       }




       /**
        * SELECT DISTINCT
        *
        * @return $this
       */
       public function distinct(): Select
       {
           $this->distinct = true;

           return $this;
       }





       /**
         * @param array $selects
         * @return $this
       */
       public function addSelect(array $selects): self
       {
            $this->selects = array_merge($this->selects, $selects);

            return $this;
       }



       /**
         * @param string $table
         * @param string $alias
         * @return $this
       */
       public function from(string $table, string $alias = ''): self
       {
             $this->table = $table;

             $this->from[$table] = sprintf('%s %s', $table, $alias);

             return $this;
       }




       /**
         * @param string $orderBy
         * @return $this
       */
       public function orderBy(string $orderBy): self
       {
            $this->orderBy[] = $orderBy;

            return $this;
       }




       /**
        * @param string $orderBy
        * @return $this
       */
       public function addOrderBy(string $orderBy): self
       {
            return $this->orderBy($orderBy);
       }




       /**
        * @param string $join
        * @return $this
       */
       public function join(string $join): self
       {
            $this->joins[] = $join;

            return $this;
       }




       /**
        * @param string $column
        * @return $this
       */
       public function groupBy(string $column): self
       {
           $this->groupBy[] = $column;

           return $this;
       }




       /**
        * @param string $column
        * @return $this
       */
       public function addGroupBy(string $column): self
       {
            return $this->groupBy($column);
       }




       /**
        * @param string $condition
        * @return $this
       */
       public function having(string $condition): self
       {
           $this->having[] = $condition;

           return $this;
       }



       /**
        * @return string
       */
       protected function openQuery(): string
       {
            return sprintf("SELECT%s %s FROM %s",
         $this->distinct ? " DISTINCT" : '',
                $this->getSelectedColumns(),
                $this->getTable()
            );;
       }





       /**
        * @return string
       */
       public function getTable(): string
       {
            if (! empty($this->from[$this->table])) {
                 return $this->from[$this->table];
            }

            return parent::getTable();
       }




       /**
        * @return string
       */
       protected function closeQuery(): string
       {
            return '';
       }




       /**
        * @return string
       */
       protected function getSelectedColumns(): string
       {
            return implode(',', $this->selects);
       }






       /**
        * @param $class
        * @return self
       */
       public function mapClass($class): self
       {
             $this->classMap = $class;

             return $this;
       }




       /**
        * @return QueryHydrateInterface
       */
       public function fetch(): QueryHydrateInterface
       {
             return $this->statement()->fetch();
       }




       /**
         * @return bool
       */
       public function execute(): bool
       {
             return false;
       }
}