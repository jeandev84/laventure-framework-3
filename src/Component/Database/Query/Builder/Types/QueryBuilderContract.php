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
    protected $builder;






    /**
     * QueryBuilderContract constructor.
     *
     * @param ConnectionInterface $connection
     * @param $table
    */
    public function __construct(ConnectionInterface $connection, $table)
    {
         $this->builder = new Builder($connection, $table);
    }





    /**
     * @param array $columns
     * @param array $criteria
     * @return Select
    */
    public function select(array $columns, array $criteria = []): Select
    {
          $builder = $this->builder->select($columns);
          $builder->criteria($criteria);
          return $this->resolve($builder);
    }





    /**
     * @param array $attributes
     * @return false|int
    */
    public function insert(array $attributes)
    {
         return $this->resolve($this->builder->insert($attributes));
    }


    
    
    
    /**
     * @param array $attributes
     * @param array $criteria
     * @return Update
    */
    public function update(array $attributes, array $criteria): Update
    {
         $query = $this->builder->update($attributes);
         $query->criteria($criteria);
         return $this->resolve($query);
    }








    /**
     * Delete query
     *
     * @return mixed
    */
    public function delete(array $criteria)
    {
        $query = $this->builder->delete();
        $query->criteria($criteria);
        return $this->resolve($query);
    }




    /**
     * @return string
    */
    public function getTable(): string
    {
        return $this->builder->getTable();
    }






    /**
     * @param SqlBuilder $command
     * @return mixed
    */
    public function resolve(SqlBuilder $command)
    {
        if ($command->getCriteria()) {
            $command = $this->resolveCriteria($command);
        }

        if ($command instanceof Insert) {
            $data = $this->resolveInsertions($command->getData());
            $command->setValues($data);
            if (! $command->execute()) {
                return false;
            }
            return $command->lastId();
        }

        if ($attributes = $command->getAttributes()){
            $command->setAttributes($this->resolveAttributes($attributes));
            $command->setParameters($attributes);
        }

        return $command;
    }





    /**
     * @param SqlBuilder $builder
     * @return mixed
    */
    protected function resolveCriteria(SqlBuilder $builder)
    {
        foreach ($builder->getCriteria() as $column => $condition) {
            $builder->where("{$column} = '{$condition}'");
        }

        return $builder;
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