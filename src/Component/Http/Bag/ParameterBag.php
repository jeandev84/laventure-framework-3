<?php
namespace Laventure\Component\Http\Bag;


/**
 * ParameterBag
*/
class ParameterBag
{

      /**
       * @var array
      */
      protected $params = [];




      /**
       * Parama
       * @param array $params
      */
      public function __construct(array $params = [])
      {
           $this->params = $params;
      }




      /**
       * Bind params
       *
       * @param $key
       * @param $value
       * @return $this
      */
      public function set($key, $value): self
      {
           $this->params[$key] = $value;

           return $this;
      }




      /**
       * @param $key
       * @return bool
      */
      public function has($key): bool
      {
          return isset($this->params[$key]);
      }




      /**
       * @param $key
       * @return bool
      */
      public function empty($key): bool
      {
           return empty($this->params[$key]);
      }




      /**
       * Get value bind param
       *
       * @param $key
       * @param $default
       * @return mixed|null
      */
      public function get($key, $default = null)
      {
          return $this->params[$key] ?? $default;
      }




      /**
       * @return array
      */
      public function all(): array
      {
          return $this->params;
      }




      /**
       * @param array $params
       * @return $this
      */
      public function merge(array $params): self
      {
           $this->params = array_merge($this->params, $params);

           return $this;
      }




      /**
       * @param $key
       * @return void
      */
      public function remove($key)
      {
           unset($this->params[$key]);
      }




      /**
       * Clean all params
       *
       * @return void
      */
      public function clear()
      {
           $this->params = [];
      }




      /**
       * @param array $params
       * @return void
      */
      public function refresh(array $params)
      {
           // todo implements
      }





      /**
       * @param $key
       * @param $value
       * @return $this
      */
      public function parse($key, $value = null): self
      {
           $this->merge(\is_array($key) ? $key : [$key => $value]);

           return $this;
      }




      /**
       * Force value to integer
       *
       * @param $key
       * @param int $default
       * @return int
      */
      public function getInt($key, int $default = 0): int
      {
            return (int) $this->get($key, $default);
      }
}