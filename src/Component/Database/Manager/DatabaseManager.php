<?php
namespace Laventure\Component\Database\Manager;

use Exception;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionStack;
use Laventure\Component\Database\Manager\Contact\DatabaseManagerInterface;


/**
 *
*/
class DatabaseManager implements DatabaseManagerInterface
{


    /**
     * @var string
    */
    protected $name;




    /**
     * Connections
     *
     * @var ConnectionInterface[]
    */
    protected $connections = [];



    /**
     * @var array
    */
    protected $connected = [];




    /**
     * @var array
    */
    protected $reconnected = [];




    /**
     * @var array
    */
    protected $disconnected = [];




    /**
     * @var array
    */
    protected $purged = [];




    /**
     * Connection credentials
     *
     * @var array
    */
    protected $configs = [];




    /**
     * DatabaseManager constructor.
    */
    public function __construct()
    {
          $this->setConnections(ConnectionStack::getDefaultConnections());
    }




    
    /**
     * @param string $name
     * @return void
    */
    public function setDefaultConnection(string $name)
    {
          $this->name = $name;
    }





    /**
     * Get default connection
     *
     * @param string|null $parsed
     * @return string
    */
    public function getDefaultConnection(string $parsed = null): string
    {
         return $parsed ?? $this->name;
    }




    /**
     * @param string|null $name
     * @return bool
    */
    public function getConnectionStatus(string $name = null): bool
    {
        return $this->connected[$this->getDefaultConnection($name)];
    }




    /**
     * @param ConnectionInterface[] $connections
     * @return $this
    */
    public function setConnections(array $connections): self
    {
        foreach ($connections as $connection) {
            $this->setConnection($connection);
        }

        return $this;
    }



    /**
     * @inheritdoc
    */
    public function getConnections(): array
    {
        return $this->connections;
    }




    /**
     * @param string $name
     * @param array $credentials
     * @return void
     */
    public function setConfiguration(string $name, array $credentials)
    {
        $this->configs[$name] = $credentials;
    }




    /**
     * @param array $parameters
     * @return void
    */
    public function setConfigurations(array $parameters)
    {
        foreach ($parameters as $name => $credentials) {
            $this->configs[$name] = $credentials;
        }
    }




    /**
     * @return array
    */
    public function getConfigurations(): array
    {
        return $this->configs;
    }






    /**
     * Attach connection
     *
     * @param ConnectionInterface $connection
     * @return $this
    */
    public function setConnection(ConnectionInterface $connection): self
    {
         $this->connections[$connection->getName()] = $connection;

         return $this;
    }





    /**
     * Detach connection
     *
     * @param string $name
     * @return void
    */
    public function removeConnection(string $name)
    {
         unset($this->connections[$name]);
    }





    /**
     * @inheritdoc
    */
    public function connect(string $name, array $credentials): void
    {
         $this->setDefaultConnection($name);
         $this->setConfiguration($name, $credentials);
    }





    /**
     * @inheritdoc
    */
    public function connection(string $name = null): ConnectionInterface
    {
         return $this->makeConnection($this->getDefaultConnection($name));
    }



    /**
     * @inheritdoc
    */
    public function disconnect(string $name = null): void
    {
        $this->disconnected[$this->getDefaultConnection($name)] = true;
    }


    

    /**
     * @inheritdoc
    */
    public function reconnect(string $name = null): void
    {
         $this->reconnected[$this->getDefaultConnection($name)] = true;
    }




    /**
     * @inheritdoc
    */
    public function purge(string $name = null): void
    {
         $this->purged[$this->getDefaultConnection($name)] = true;
    }





    /**
     * @param string $name
     * @return array
    */
    protected function configuration(string $name): array
    {
         return $this->configs[$name] ?? [];
    }



    /**
     * @param string $name
     * @return ConnectionInterface
    */
    protected function makeConnection(string $name): ConnectionInterface
    {
        if (! empty($this->purged[$name])) {
            $this->removeConnection($name);
        }

        if (! $this->hasConnection($name)) {
            $this->abortIf("Unable connection '{$name}'", __METHOD__);
        }

        $connection = $this->connections[$name];

        if($credentials = $this->configuration($name)) {
            $connection->connect($credentials);
        }

        if (! empty($this->reconnected[$name]) || $connection->reconnected()) {
            $connection->reconnect();
        }

        if (! empty($this->disconnected[$name])) {
            $connection->disconnect();
        }

        $this->setDefaultConnection($name);

        $this->connected[$name] = $connection->connected();

        return $connection;
    }





    /**
     * Determine if the given name isset
     *
     * @param string|null $name
     * @return bool
    */
    protected function hasConnection(string $name): bool
    {
        return isset($this->connections[$name]);
    }





    /**
     * @param string $message
     * @param string $method
     * @return null
    */
    protected function abortIf(string $message, string $method = '')
    {
          if ($method) { $message .= " , method : {$method}";}

          return (function () use ($message) {
               throw new Exception($message);
          })();
    }
}