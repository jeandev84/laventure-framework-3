<?php
namespace Laventure\Component\Database\ORM\Mapper\Query\Builder\SQL\Commands;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Query\Query;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;


/**
 * SelectBuilder
*/
class SelectBuilder extends Select
{

        /**
         * @var EntityManager
        */
        protected $em;





        /**
         * With entity manager
         *
         * @param EntityManager $em
         * @return $this
        */
        public function manager(EntityManager $em): self
        {
              $this->em = $em;

              return $this;
        }




        /**
         * @return Query
        */
        public function getQuery(): Query
        {
             $this->mapClass($this->em->getClassName());
             $statement = $this->statement();
             return new Query($this->em, $statement);
        }
}