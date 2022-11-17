<?php
namespace Laventure\Component\Database\ORM\Mapper\Query;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL\SelectQuery;
use Laventure\Component\Database\Query\Builder\SQL\Command\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Command\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\Builder\SQL\Command\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;
use Laventure\Component\Database\Query\QueryBuilder as QB;
use Laventure\Component\Database\Query\Resolver\QueryResolver;


/**
 * @class QueryBuilder
 *
 * @package Laventure\Component\Database\ORM\Mapper\Query
 *
 * @author
*/
class QueryBuilder
{


    /**
     * @var EntityManager
    */
    protected $em;





    /**
     * @var QB
    */
    protected $builder;






    /**
     * @var array
    */
    protected $wheres = [];





    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
          $this->builder = new QB($em->getConnectionManager(), $em->getTableName());
          $this->em      = $em;
    }





    /**
     * @param array $columns
     * @param array $criteria
     * @return Select
    */
    public function select(array $columns = ["*"], array $criteria = []): Select
    {
          $command = new SelectQuery($this->em);
          $command->addSelect($columns);
          $command->addWheres($this->resolveWheres($criteria));
          return $command;
    }






    /**
     * @param array $attributes
     * @return Insert
    */
    public function insert(array $attributes): Insert
    {
         return $this->builder->insert($attributes);
    }





    /**
     * @param array $attributes
     * @param array $criteria
     * @return Update
    */
    public function update(array $attributes, array $criteria): Update
    {
         $update = $this->builder->update($attributes);
         $update->addWheres($this->resolveWheres($criteria));
         return $update;
    }






    /**
     * @param array $criteria
     * @return Delete
    */
    public function delete(array $criteria): Delete
    {
          $command = $this->builder->delete();
          $command->addWheres($this->resolveWheres($criteria));
          return $command;
    }







    /**
     * @param array $wheres
     * @return array
    */
    private function resolveWheres(array $wheres): array
    {
         return $this->resolve()->resolveWheres($wheres);
    }






    /**
     * @return QueryResolver
    */
    private function resolve(): QueryResolver
    {
        return $this->builder->getResolver();
    }
}