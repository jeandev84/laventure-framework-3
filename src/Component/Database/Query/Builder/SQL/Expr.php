<?php
namespace Laventure\Component\Database\Query\Builder\SQL;



/**
 * Expression builder
*/
class Expr
{


     /**
      * @var SqlBuilder
     */
     protected $builder;




     /**
      * @param SqlBuilder $builder
     */
     public function __construct(SqlBuilder $builder)
     {
           $this->builder = $builder;
     }




     /**
      * @return $this
     */
     public function sum(): self
     {
          return $this;
     }




     /**
      * @return $this
     */
     public function like(): self
     {
          return $this;
     }




     /**
      * @return $this
     */
     public function avg(): self
     {
          return $this;
     }
}