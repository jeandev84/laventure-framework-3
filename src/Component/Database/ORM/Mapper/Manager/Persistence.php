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
      protected $primaryKey = 'id';




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
       * @var int
      */
      protected $id;




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
      public function setPrimaryKey($name)
      {
            $this->primaryKey = $name;
      }






      /**
       * @return string
      */
      public function primaryKey(): string
      {
           return $this->primaryKey;
      }





      /**
       * @return int
      */
      public function getId(): ?int
      {
           return $this->id;
      }






      /**
       * @param object $object
       * @return int|null
      */
      public function getObjectID($object): ?int
      {
            return $this->dataMapper->getId($object);
      }




      /**
       * @param object $object
       * @return $this
      */
      public function persist(object $object): self
      {
            $this->persists[] = $object;

            return $this;
      }





      /**
       * @param object $object
       * @return $this
      */
      public function remove(object $object): self
      {
           $this->deletions[] = $object;

           return $this;
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

                 $this->em->registerClass($name = $this->className($object));

                 if ($id = $this->getObjectID($object)) {
                     $attributes = $this->updateAttributes($object);
                     $this->em->update($attributes, [$this->primaryKey() => $id]);
                     $this->updated[$name][] = $id;
                 }else{
                     $attributes = $this->insertAttributes($object);
                     $id = $this->em->insert($attributes);
                     $this->inserted[$name][] = $id;
                     $this->id = $id;
                 }
           }
      }




      /**
       * @return void
      */
      public function delete()
      {
          foreach ($this->deletions as $object) {

              $this->em->registerClass($name = $this->className($object));

              $object = $this->preRemove($object);

              if ($id = $this->getObjectID($object)) {
                   $this->em->delete([$this->primaryKey() => $id]);
                   $this->deleted[$name][] = $id;
              }
          }
      }





      /**
       * @param object $object
       * @return array
      */
      public function getAttributesToSave(object $object): array
      {
            $attributes = $this->dataMapper->map($object);

            unset($attributes[$this->primaryKey()]);

            return $attributes;
      }




      /**
       * @param object $object
       * @return array
      */
      public function updateAttributes(object $object): array
      {
            $object = $this->eventManager->preUpdate($object);

            return $this->getAttributesToSave($object);
      }




      /**
       * @param object $object
       * @return array
      */
      public function insertAttributes(object $object): array
      {
          $object = $this->eventManager->prePersist($object);

          return $this->getAttributesToSave($object);
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
      public function className($object): string
      {
           return $this->em->classMap()
                           ->map($object)
                           ->className();
      }
}