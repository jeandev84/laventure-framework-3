<?php
namespace Laventure\Component\Database\Connection;


use Exception;
use Laventure\Component\Database\Connection\Configuration\ConfigurationBag;
use Laventure\Component\Database\Connection\Configuration\ConfigurationBagInterface;
use Laventure\Component\Database\Connection\Exception\ConnectionException;
use Laventure\Component\Database\Connection\Query\QueryInterface;


/**
 *
*/
abstract class Connection  implements ConnectionInterface
{


    /**
     * @var mixed
    */
    protected $connection;



    /**
     * @var QueryInterface
    */
    protected $statement;



    /**
     * @var ConfigurationBag
    */
    protected $config;




    /**
     * @param $connection
     * @return void
    */
    protected function setConnection($connection)
    {
         $this->connection = $connection;
    }




    /**
     * @return mixed
    */
    public function getConnection()
    {
         if (! $this->connection) {
             $this->createConnectionException("Unable connection for : " . get_called_class());
         }

         return $this->connection;
    }




    /**
     * @param QueryInterface $statement
     * @return void
     */
    public function setStatement(QueryInterface $statement)
    {
         $this->statement = $statement;
    }




    /**
     * @return array|string[]
    */
    public function getQueryLog(): array
    {
        return $this->statement->getQueryLog();
    }





    /**
     * @param array $credentials
     * @return void
    */
    public function addCredentials(array $credentials)
    {
         $this->config = new ConfigurationBag($credentials);
    }





    /**
     * @return array
    */
    protected function getCredentials(): array
    {
        return $this->config->all();
    }




    /**
     * @return ConfigurationBagInterface
    */
    public function getConfigurationBag(): ConfigurationBagInterface
    {
        return $this->config;
    }




    /**
     * @inheritDoc
    */
    public function config($name = null)
    {
        return $this->config->get($name);
    }






    /**
     * @inheritDoc
    */
    public function getDatabase()
    {
        return $this->config->getDatabase();
    }




    /**
     * @inheritDoc
    */
    public function prepareTable($table): string
    {
         return sprintf('%s%s', $this->config->getPrefix(), $table);
    }





    /**
     * @inheritdoc
    */
    public function createDatabase(): bool
    {
         return false;
    }




    /**
     * @inheritdoc
    */
    public function dropDatabase(): bool
    {
         return false;
    }




    /**
     *
     * @inheritdoc
    */
    public function showTables(): array
    {
         return [];
    }




    /**
     * @inheritdoc
    */
    public function showDatabases(): array
    {
         return [];
    }



    /**
     * @return bool
    */
    public function existDatabase(): bool
    {
        $database = $this->getDatabase();

        return ! is_null($database) && in_array($database, $this->showDatabases());
    }





    /**
     * @param string $message
     * @return mixed
    */
    protected function createConnectionException(string $message) {
        return (function () use ($message) {
            throw new ConnectionException($message);
        })();
    }
}