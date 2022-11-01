<?php
namespace Laventure\Component\Database\ORM\Mapper\Service;


use DateTimeInterface;
use Laventure\Component\Database\ORM\Mapper\Service\Exception\DataMapperException;
use Laventure\Component\Database\ORM\Mapper\Service\Resolver\DataMapperResolver;

/**
 *
*/
class DataMapper
{

       /**
        * @var DataMapperResolver
       */
       protected $dataMapperResolver;




       /**
        * DataMapper constructor.
       */
       public function __construct()
       {
            $this->dataMapperResolver = new DataMapperResolver();
       }



       /**
        * Map object attributes
        *
        * @param object $object
        * @return array
       */
       public function map(object $object): array
       {
            $reflection = new \ReflectionObject($object);

            $attributes = [];

            foreach ($reflection->getProperties() as $property) {

                $property->setAccessible(true);

                $value = $this->dataMapperResolver->resolveValue(
                    $property->getValue($object)
                );

                $attributes[$property->getName()] = $value;
            }

            return $attributes;
      }




      /**
       * @param object $object
       * @return int|null
      */
      public function getId(object $object): ?int
      {
           if (! method_exists($object, 'getId')) {
              $this->createDataMapperException(
                  "You must to implement method getId() inside entity class '". get_class($object) . "'"
              );
          }

          return $object->getId();
      }



      /**
       * @param object $object
       * @return string
      */
      public function getClassName(object $object): string
      {
           return get_class($object);
      }




      /**
       * @param $message
       * @return mixed
      */
      protected function createDataMapperException($message)
      {
           return (function () use ($message) {
               throw new DataMapperException($message);
           })();
      }
}