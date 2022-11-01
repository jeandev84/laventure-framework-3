<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Event\Contract;

/**
 *
*/
interface EntityEventManagerInterface
{
     /**
      * @param $object
      * @return object
     */
     public function preUpdate($object): object;




     /**
      * @param $object
      * @return object
     */
     public function prePersist($object): object;




     /**
      * @param $object
      * @return object
     */
     public function preRemove($object): object;
}