<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Contact;


/**
 *
*/
interface ObjectManager
{
      /**
       * @param $object
       * @return mixed
      */
      public function persist($object);



      /**
       * @param $object
       * @return mixed
      */
      public function remove($object);




      /**
        * @param $object
        * @return mixed
      */
      public function attach($object);




      /**
       * @param $object
       * @return mixed
      */
      public function detach($object);
}