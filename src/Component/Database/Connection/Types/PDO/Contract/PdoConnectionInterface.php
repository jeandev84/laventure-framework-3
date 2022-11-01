<?php
namespace Laventure\Component\Database\Connection\Types\PDO\Contract;

/**
 *
*/
interface PdoConnectionInterface
{
      /**
       * @return \PDO
      */
      public function getPDO(): \PDO;
}