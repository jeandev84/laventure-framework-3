<?php
namespace Laventure\Component\Database\Connection\Types\PDO;


use Laventure\Component\Database\Connection\Query\QueryHydrateInterface;
use PDO;


/**
 * Hydrate
*/
class Hydrate implements QueryHydrateInterface
{


      /**
       * @var \PDOStatement
      */
      protected $statement;




      /**
       * @var int
      */
      protected $fetchMode;




      /**
       * @param \PDOStatement $statement
       * @param $fetchMode
      */
      public function __construct(\PDOStatement $statement, $fetchMode)
      {
             $this->statement = $statement;
             $this->fetchMode = $fetchMode;
      }




      /**
       * @return array|false
      */
      public function all()
      {
           return $this->statement->fetchAll($this->fetchMode);
      }



      /**
       * @return mixed
      */
      public function one()
      {
          return $this->statement->fetch($this->fetchMode);
      }




      /**
       * @return array
      */
      public function columns(): array
      {
           return $this->statement->fetchAll(PDO::FETCH_COLUMN);
      }




      /**
       * @return array|false
      */
      public function asArray()
      {
           return $this->statement->fetchAll(PDO::FETCH_ASSOC);
      }




      /**
       * @param array $columns
       * @return mixed
      */
      public function column(array $columns = [])
      {
           return $this->statement->fetchColumn($columns);
      }



      /**
       * @return mixed
      */
      public function object()
      {
          return $this->statement->fetchObject();
      }




      /**
       * @return int
      */
      public function count(): int
      {
          return $this->statement->rowCount();
      }
}