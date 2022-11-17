<?php
namespace Laventure\Component\Database\Query\Builder\Types;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\Builder;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilderFactory;


/**
 * @class QueryBuilderContract
*/
abstract class QueryBuilderContract
{


    /**
     * @var Builder
    */
    protected $query;





    /**
     * QueryBuilderContract constructor.
     *
     * @param ConnectionInterface $connection
     * @param $table
    */
    public function __construct(ConnectionInterface $connection, $table)
    {
         $this->query = new Builder($connection, $table);
    }





    /**
     * @param array $columns
     * @return Select
    */
    public function select(array $columns): Select
    {
          return $this->resolve($this->query->select($columns));
    }





    /**
     * @param array $attributes
     * @return Insert
    */
    public function insert(array $attributes): Insert
    {
         return $this->resolve($this->query->insert($attributes));
    }





    /**
     * @param array $attributes
     * @return mixed
    */
    public function update(array $attributes)
    {
         return $this->resolve($this->query->update($attributes));
    }







    /**
     * Delete query
     *
     * @return mixed
    */
    public function delete()
    {
        return $this->resolve($this->query->delete());
    }




    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->query->getTable();
    }






    /**
     * @return SqlBuilderFactory
    */
    public function factory(): SqlBuilderFactory
    {
        return $this->query->getFactory();
    }





    /**
     * @param SqlBuilder $command
     * @return mixed
    */
    public function resolve(SqlBuilder $command)
    {
        if ($wheres = $command->getWheres()) {
            $command->refreshWheres($this->resolveWheres($wheres));
        }elseif ($command instanceof Insert) {
            $data = $this->resolveInsertions($command->getData());
            $command->refreshValues($data);
        } elseif ($attributes = $command->getAttributes()){
            $command->setAttributes($this->resolveAttributes($attributes));
            $command->setParameters($attributes);
        }

        return $command;
    }





    /**
     * @param array $wheres
     * @return array
    */
    protected function resolveWheres(array $wheres): array
    {
        $criteria = [];

        foreach ($wheres as $column => $condition) {
            $criteria[] = "{$column} = '{$condition}'";
        }

        return $criteria;
    }





    /**
     * Resolve insertion attributes
     *
     * @param array $arguments
     * @return array
     */
    protected function resolveInsertions(array $arguments): array
    {
        $resolved = [];

        foreach ($arguments as $index => $credentials) {
            foreach ($credentials as $column => $value) {
                $resolved[$index][$column] = "'{$value}'";
            }
        }

        return $resolved;
    }




    /**
     * @param array $attributes
     * @return array
    */
    protected function resolveAttributes(array $attributes): array
    {
         $resolved = [];
         foreach ($attributes as $column => $value) {
             $resolved[$column] = "'{$value}'";
         }
         return $resolved;
    }
}