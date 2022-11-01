<?php
namespace Laventure\Component\Database\Manager\Contact;

use Laventure\Component\Database\Connection\ConnectionInterface;

/**
 *
*/
interface DatabaseManagerInterface
{

      /**
       * @return ConnectionInterface[]
      */
      public function getConnections(): array;


      /**
       * @return array
      */
      public function getConfigurations(): array;




      /**
       * Connect to default connection
       *
       * @param string $name
       * @param array $credentials
       * @return void
      */
      public function connect(string $name, array $credentials): void;




      /**
       * Get connection
       *
       * @param string|null $name
       * @return ConnectionInterface
      */
      public function connection(string $name = null): ConnectionInterface;






      /**
       * Disconnect to database
       *
       * @param string|null $name
       * @return void
      */
      public function disconnect(string $name = null): void;





      /**
       * Reconnect to database
       *
       * @param string|null $name
       * @return void
      */
      public function reconnect(string $name = null): void;






      /**
       * Forget connection
       *
       * @param string|null $name
       * @return void
      */
      public function purge(string $name = null): void;
}