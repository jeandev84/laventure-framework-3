<?php
namespace Laventure\Component\Database\Query\Builder\SQL;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;


/**
 * SqlBuilder
*/
abstract class SqlBuilder
{

      /**
       * @var string
      */
      protected $table;



      /**
       * @var string
      */
      protected $classMap;




      /**
       * @var array
      */
      protected $assigned = [];




      /**
       * @var array
      */
      protected $wheres = [];




      /**
       * @var array
      */
      protected $parameters = [];





      /**
       * @var ConnectionInterface
      */
      protected $connection;



      /**
       * @param string $table
      */
      public function __construct(string $table)
      {
            $this->table = $table;
      }




      /**
       * @param ConnectionInterface $connection
       * @return $this
      */
      public function connection(ConnectionInterface $connection): self
      {
            $this->connection = $connection;

            return $this;
      }



      /**
       * @return string
      */
      public function getTable(): string
      {
          return $this->table;
      }




      /**
       * @param string $name
       * @param $value
       * @return $this
      */
      public function set(string $name, $value): self
      {
           $this->assigned[$name] = $value;

           return $this;
      }



      /**
       * @param array $attributes
       * @return void
      */
      public function setColumns(array $attributes)
      {
           foreach ($attributes as $name => $value) {
                $this->set($name, $value);
           }
      }




      /**
       * @return array
      */
      public function getAssigned(): array
      {
            return $this->assigned;
      }



      /**
       * @return array
      */
      public function assignColumns(): array
      {
            $attributes = [];

            foreach ($this->getAssigned() as $name => $value) {
                $attributes[] = sprintf("%s = '%s'", $name, $value);
            }

            return $attributes;
      }



      /**
       * @return string
      */
      protected function makeSET(): string
      {
           return sprintf('SET %s', join(", ", $this->assignColumns()));
      }




      /**
        * @param string $condition
        * @return $this
      */
      public function where(string $condition): self
      {
            return $this->andWhere($condition);
      }




      /**
       * @param string $condition
       * @return $this
      */
      public function andWhere(string $condition): self
      {
           $this->wheres['AND'][] = $condition;

           return $this;
      }



      /**
       * @param string $condition
       * @return $this
      */
      public function orWhere(string $condition): self
      {
          $this->wheres['OR'][] = $condition;

          return $this;
      }




      /**
       * @param string $condition
       * @return $this
      */
      public function notWhere(string $condition): self
      {
           return $this->andWhere("NOT $condition");
      }



      /**
       * @param $column
       * @param $value
       * @return $this
      */
      public function whereLike($column, $value): self
      {
           return $this->andWhere("$column LIKE $value");
      }



      /**
       * @param string $column
       * @param string $start
       * @param string $end
       * @return $this
      */
      public function whereBetween(string $column, string $start, string $end): self
      {
            return $this->andWhere("$column BETWEEN $start AND $end");
      }




      /**
       * @param string $column
       * @param string $first
       * @param string $end
       * @return $this
      */
      public function whereNotBetween(string $column, string $first, string $end): self
      {
           return $this->whereBetween("$column NOT", $first, $end);
      }



      /**
       * @param string $column
       * @param array $data
       * @return $this
      */
      public function whereIn(string $column, array $data): self
      {
            $values = "'". implode("', '", $data) . "'";

            return $this->andWhere(sprintf("%s IN (%s)", $column, $values));
      }




      /**
       * @return Expr
      */
      public function expr(): Expr
      {
           return new Expr($this);
      }



      /**
       * @param string $column
       * @param array $data
       * @return $this
      */
      public function whereNotIn(string $column, array $data): self
      {
            return $this->whereIn("$column NOT", $data);
      }




      /**
       * @param string $name
       * @param $value
       * @return $this
      */
      public function setParameter(string $name, $value): self
      {
           return $this->setParameters([$name => $value]);
      }




      /**
       * @param array $parameters
       * @return $this
      */
      public function setParameters(array $parameters): self
      {
            $this->parameters = array_merge($this->parameters, $parameters);

            return $this;
       }




      /**
       * @return array
      */
      public function getParameters(): array
      {
           return $this->parameters;
      }



      /**
       * @return string
      */
      public function getSQL(): string
      {
          $sql = implode(' ', [
              $this->openSQL(),
              $this->makeConditions(),
              $this->closeSQL()
          ]);

          return sprintf('%s;', trim($sql, ' '));
      }




      /**
       * @return string
      */
      public function makeConditions(): string
      {
            if (! $this->wheres) {
                 return '';
            }

            return sprintf('WHERE %s', $this->buildConditions());
      }




      /**
       * @return string
      */
      public function buildConditions(): string
      {
            $wheres = [];

            $key = key($this->wheres);

            foreach ($this->wheres as $operator => $conditions) {

                 if ($key !== $operator) {
                     $wheres[] = $operator;;
                 }

                 $wheres[] =  implode(" ". $operator . " ", $conditions);
            }

            return join(' ', $wheres);
      }




      /**
       * Query statement
       *
       * @return QueryInterface
      */
      public function statement(): QueryInterface
      {
            $statement = $this->connection->statement($this->getSQL(), $this->getParameters());

            if ($this->classMap) {
                $statement->map($this->classMap);
            }

            return $statement;
      }




      /**
       * @return bool
      */
      public function execute(): bool
      {
           return $this->statement()->execute();
      }




      /**
       * @return int
      */
      public function lastId(): int
      {
           return $this->statement()->lastId();
      }




      /**
        * @return string
      */
      abstract protected function openSQL(): string;




      /**
       * @return string
      */
      protected function closeSQL(): string
      {
            return "";
      }
}