<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository;

trait EntityRepositoryResolver
{
      /**
       * @param $name
       * @param $arguments
       * @return mixed|void
      */
      public function resolveCallbackMethods($name, $arguments)
      {
          $reflection = new \ReflectionObject($this);

          $methods = [];

          foreach ($reflection->getMethods() as $method) {
              $methods[] = $method->getName();
          }

          foreach ($methods as $method) {
              if (stripos($name, $method) !== false) {
                  $property = strtolower(str_replace($method, '', $name));
                  return call_user_func([$this, $method], [ $property => $arguments[0]]);
              }
          }

          return false;
      }
}