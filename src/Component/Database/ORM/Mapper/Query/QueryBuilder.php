<?php
namespace Laventure\Component\Database\ORM\Mapper\Query;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL\Commands\SelectBuilder;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;
use Laventure\Component\Database\Query\QueryBuilder as Builder;



/**
 * QueryBuilder
*/
class QueryBuilder extends Builder
{


    /**
     * @var EntityManager
    */
    protected $em;



    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
         parent::__construct($em->getConnectionManager(), $em->getTableName());
         $this->em = $em;
    }




    /**
     * @param array $selects
     * @return Select
    */
    public function select(array $selects = ["*"]): Select
    {
          /** @var SelectBuilder $command */
          $command = $this->builder->resolveCommandSQL(
              new SelectBuilder($selects, $this->getTable())
          );

          $command->manager($this->em);

          return $command;
    }
}