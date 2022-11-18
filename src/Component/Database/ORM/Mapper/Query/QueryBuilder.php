<?php
namespace Laventure\Component\Database\ORM\Mapper\Query;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL\SelectQuery;
use Laventure\Component\Database\Query\QueryBuilder as QB;



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
    protected $qb;





    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
          $this->qb = new QB($em->getConnectionManager(), $em->getTableName());
          $this->em = $em;
    }





    /**
     * @param array $columns
     * @param array $criteria
     * @return SelectQuery
    */
    public function select(array $columns = ["*"], array $criteria = []): SelectQuery
    {
            $query = new SelectQuery($this->em);
            $query->addSelect($columns);
            $query->addCriteria($criteria);

            return $this->qb->resolve($query);
    }
}