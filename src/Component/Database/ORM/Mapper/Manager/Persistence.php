<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;


use Laventure\Component\Database\ORM\Mapper\Manager\Event\Contract\EntityEventManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Event\EntityEventManager;
use Laventure\Component\Database\ORM\Mapper\Service\DataMapper;

/**
 *
*/
class Persistence
{

      /**
       * @var string
      */
      protected $identity = 'id';




      /**
       * @var EntityManager
      */
      protected $em;




      /**
       * @var array
      */
      protected $updates = [];



      /**
       * @var array
      */
      protected $updated = [];



      /**
       * @var array
      */
      protected $inserted = [];




      /**
       * @var array
      */
      protected $deletions = [];



      /**
       * @var array
      */
      protected $deleted = [];



      /**
       * @var array
      */
      protected $persists = [];



      /**
       * @var array
      */
      protected $persisted = [];




      /**
       * @var DataMapper
      */
      protected $dataMapper;




      /**
       * @var EntityEventManagerInterface
      */
      protected $eventManager;


      /**
       * Persistence constructor.
       *
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
             $this->em           = $em;
             $this->eventManager = $em->getEventManager();
             $this->dataMapper   = new DataMapper();
      }





      /**
       * @param $name
       * @return void
      */
      public function identity($name)
      {
            $this->identity = $name;
      }



      /**
       * @return string
      */
      public function getIdentity(): string
      {
           return $this->identity;
      }




      /**
       * @param object $object
       * @return int|null
      */
      public function getId(object $object): ?int
      {
            return $this->dataMapper->getId($object);
      }




      /**
       * @param $object
       * @return $this
      */
      public function persist($object): self
      {
            $this->persists[] = $object;

            return $this;
      }




      /**
       * @param array $objects
       * @return $this
      */
      public function persists(array $objects): self
      {
          foreach ($objects as $object) {
               $this->persist($object);
          }

          return $this;
      }




      /**
       * @param $object
       * @return $this
      */
      public function remove($object): self
      {
           $this->deletions[] = $object;

           return $this;
      }




      /**
       * @param array $objects
       * @return void
      */
      public function removes(array $objects)
      {
            $this->deletions = array_merge($this->deletions, $objects);
      }




      /**
       * @return void
      */
      public function flush()
      {
           $this->em->transaction(function () {
                 $this->save();
                 $this->delete();
           });
      }



      /**
       * @return void
      */
      public function save()
      {
           foreach ($this->persists as $object) {

                 $className = $this->getClassName($object);

                 if ($id = $this->getId($object)) {
                     $attributes = $this->getAttributesToUpdate($object);
                     $this->em->update($attributes, [$this->getIdentity() => $id]);
                     $this->updated[$className][] = $id;
                 }else{
                     $attributes = $this->getAttributesToPersist($object);
                     $this->em->insert($attributes);

                     /* $this->inserted[$className][] = $this->em->lastInsertId(); */
                 }
           }
      }




      /**
       * @return void
      */
      public function delete()
      {
          foreach ($this->deletions as $object) {
              if ($id = $this->getId($object)) {
                   $object = $this->preRemove($object);
                   $this->em->delete([$this->getIdentity() => $id]);
                   $this->deleted[$this->getClassName($object)][] = $id;
              }
          }
      }



      /**
       * @param object $object
       * @return array
      */
      public function getPersistenceAttributes(object $object): array
      {
            $attributes = $this->dataMapper->map($object);

            unset($attributes[$this->getIdentity()]);

            return $attributes;
      }




      /**
       * @param object $object
       * @return array
      */
      public function getAttributesToUpdate(object $object): array
      {
            $object = $this->eventManager->preUpdate($object);

            return $this->getPersistenceAttributes($object);
      }




      /**
       * @param object $object
       * @return array
      */
      public function getAttributesToPersist(object $object): array
      {
          $object = $this->eventManager->prePersist($object);

          return $this->getPersistenceAttributes($object);
      }




      /**
       * @param object $object
       * @return object
      */
      public function preRemove(object $object): object
      {
            return $this->eventManager->preRemove($object);
      }



      /**
       * @param $object
       * @return string
      */
      public function getClassName($object): string
      {
           return $this->dataMapper->getClassName($object);
      }
}