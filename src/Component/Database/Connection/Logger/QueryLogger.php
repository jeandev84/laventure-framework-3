<?php
namespace Laventure\Component\Database\Connection\Logger;

class QueryLogger
{

      /**
       * @var string
      */
      protected $sql;




      /**
       * @var array
      */
      protected $params;




      /**
       * @param string $sql
       * @param array $params
      */
      public function __construct(string $sql, array $params = [])
      {
           $this->sql    = $sql;
           $this->params = $params;
      }




      /**
       * @return string
      */
      public function __toString(): string
      {
          $params = implode(',', array_values($this->params));

          return sprintf('%s: %s, [%s]', date('Y-m-d H:i:s'), $this->sql, $params);
      }
}