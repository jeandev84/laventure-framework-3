<?php
namespace Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL;



use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\Query;
use Laventure\Component\Database\Query\Builder\SQL\Command\Select;



/**
 * @class SelectQuery
 *
 * @package Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL
 *
 * @author
*/
class SelectQuery extends Select
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
        }






        /**
         * @return Query
        */
        public function getQuery(): Query
        {
             return new Query($this->em, $this->getStatement());
        }
}