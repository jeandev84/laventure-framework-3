<?php
namespace Laventure\Component\Database\Connection\Types\PDO;

use Laventure\Component\Database\Connection\Exception\StatementException;
use Laventure\Component\Database\Connection\Logger\QueryLogger;
use Laventure\Component\Database\Connection\Query\QueryHydrateInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use PDOException;


/**
 *
*/
class Statement implements QueryInterface
{


    /**
     * @var \PDO
    */
    protected $pdo;




    /**
     * @var \PDOStatement
    */
    protected $statement;




    /**
     * @var string
    */
    protected $sql;




    /**
     * @var int
    */
    protected $fetchMode;



    /**
     * @var string
    */
    protected $classMap;



    /**
     * @var int
    */
    protected $lastId;



    /**
     * @var array
    */
    protected $params = [];




    /**
     * @var array
    */
    protected $bindValues = [];




    /**
     * @var array
    */
    protected $queriesLog = [];





    /**
     * @param \PDO $pdo
    */
    public function __construct(\PDO $pdo)
    {
          $this->pdo = $pdo;
    }






    /**
     * @param string $sql
     * @return $this
    */
    public function prepare($sql): QueryInterface
    {
         $this->sql = $sql;

         $this->statement = $this->pdo->prepare($sql);

         return $this;
    }




    /**
     * @inheritDoc
    */
    public function map($class): QueryInterface
    {
         if ($class) {

             $this->classMap = (string) $class;

             $this->statement->setFetchMode(\PDO::FETCH_CLASS, $this->classMap);
         }

         return $this;
    }





    /**
     * Set fetch Mode
     *
     * @param int $mode
     * @return Statement
    */
    public function fetchMode(int $mode): self
    {
         $this->fetchMode = $mode;

         return $this;
    }






    /**
     * @inheritDoc
    */
    public function params(array $params): QueryInterface
    {
          $this->params = $params;

          return $this;
    }




    /**
     * Bind param
     *
     * @param string $param
     * @param $value
     * @param int $type
     * @return $this
    */
    public function bindValues(string $param, $value, int $type = 0): self
    {
            if ($type === 0) {

                $name = strtolower(gettype($value));

                $type = [
                   'integer' => \PDO::PARAM_INT,
                   'boolean' => \PDO::PARAM_BOOL,
                   'null'    => \PDO::PARAM_NULL,
                ][$name] ?? \PDO::PARAM_STR;
            }

            $this->statement->bindValue(":{$param}", $value, $type);

            $this->bindValues[] = [$param => $value];

            return $this;
    }





    /**
     * @return bool
    */
    public function execute(): bool
    {
        try {

            if($this->statement->execute($this->params)) {

                 $params = $this->params ?? $this->bindValues;
                 $this->log($this->sql, $params);
                 return true;
            }

        } catch (PDOException $e) {

             return (function () use ($e) {

                 throw new StatementException($e->getMessage());

             })();
        }

        return false;
    }




    /**
     * @param $sql
     * @return bool
    */
    public function exec($sql): bool
    {
         if (! is_int($this->pdo->exec($sql))) {
             return false;
         }

         $this->log($sql);

         return true;
    }




    /**
     * @inheritdoc
    */
    public function beginTransaction()
    {
         $this->pdo->beginTransaction();
    }




    /**
     * @inheritdoc
    */
    public function commit()
    {
        $this->pdo->commit();
    }




    /**
     * @inheritdoc
    */
    public function rollback()
    {
        $this->pdo->rollBack();
    }




     /**
      * @return QueryHydrateInterface
     */
     public function fetch(): QueryHydrateInterface
     {
          $this->execute();

          return new Hydrate($this->statement, $this->fetchMode);
     }





    /**
     * @inheritDoc
    */
    public function fetchAll()
    {
         return $this->fetch()->all();
    }




    /**
     * @inheritDoc
    */
    public function fetchOne()
    {
         return $this->fetch()->one();
    }


    

    /**
     * @inheritDoc
    */
    public function fetchColumns()
    {
         return $this->fetch()->columns();
    }





    /**
     * @return int
    */
    public function rowCount(): int
    {
        return $this->fetch()->count();
    }





    /**
     * @return array
    */
    public function errors(): array
    {
        return $this->statement->errorInfo();
    }





    /**
     * @param $name
     * @return int
    */
    public function lastId($name = null): int
    {
        return $this->pdo->lastInsertId($name);
    }




    /**
     * @return string[]
    */
    public function getQueryLog(): array
    {
        return $this->queriesLog;
    }




    /**
     * @param $sql
     * @param array $params
     * @return void
    */
    public function log($sql, array $params = [])
    {
          $this->queriesLog[] = new QueryLogger($sql, $params);
    }
}