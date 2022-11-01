<?php
namespace Laventure\Component\Database\Connection\Types\PDO;

use Closure;
use Exception;
use Laventure\Component\Database\Connection\Connection;
use Laventure\Component\Database\Connection\ConnectionType;
use Laventure\Component\Database\Connection\Exception\DriverConnectionException;
use Laventure\Component\Database\Connection\Types\PDO\Contract\PdoConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use PDO;
use PDOException;


/**
 * PdoConnection
*/
class PdoConnection extends Connection implements PdoConnectionInterface
{

    /**
     * @var array
    */
    protected $defaultOptions = [
        PDO::ATTR_PERSISTENT          => true,
        PDO::ATTR_EMULATE_PREPARES    => 0,
        PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
    ];



    /**
     * @var PDO
    */
    protected $connection;


    /**
     * PdoConnection constructor.
     *
     * @param array $credentials
     * @throws DriverConnectionException
    */
    public function __construct(array $credentials = [])
    {
          if ($credentials) {
              $this->connect($credentials);
          }
    }



    /**
     * @inheritdoc
    */
    public function getTypeName(): string
    {
          return ConnectionType::PDO;
    }




    /**
     * @return string
    */
    public function getName(): string
    {
         return 'pdo.connection';
    }



    /**
     * @return PDO
    */
    public function getPDO(): \PDO
    {
         return $this->getConnection();
    }


    /**
     * @inheritdoc
     * @throws DriverConnectionException
    */
    public function connect($credentials)
    {
          $this->addCredentials($credentials);
          $this->setupConnection($credentials);
    }




    /**
     * @return bool
    */
    public function connected(): bool
    {
        return $this->connection instanceof \PDO;
    }




    /**
     * @return void
     * @throws DriverConnectionException
    */
    public function reconnect()
    {
        if ($this->existDatabase()) {
             $this->connectToPdo($this->getCredentials());
        }
    }





    /**
     * @inheritdoc
    */
    public function reconnected(): bool
    {
         return true;
    }





    /**
     * @return void
    */
    public function disconnect()
    {
         $this->connection = null;
    }




    /**
     * Make PDO connection
     *
     * @param array $config
     * @return PDO
     * @throws Exception
    */
    public function makePDO(array $config): PDO
    {
            try {

                $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

                $config['options'][] = sprintf("SET NAMES '%s'", $config['charset'] ?? 'utf8');

                $this->setPdoOptions($pdo, $config['options']);

                return $pdo;

            } catch (PDOException $e) {

                 throw new Exception($e->getMessage());
            }
    }



    /**
     * @param PDO $pdo
     * @param array $options
     * @return void
    */
    public function setPdoOptions(PDO $pdo, array $options)
    {
        foreach ($options as $option) {
            $pdo->exec($option);
        }

        foreach ($this->defaultOptions as $key => $value) {
            $pdo->setAttribute($key, $value);
        }
    }




    /**
     * @param string $name
     * @return bool
    */
    public function has(string $name): bool
    {
          return \in_array($name, PDO::getAvailableDrivers());
    }




    /**
     * @inheritDoc
    */
    public function beginTransaction()
    {
        $this->statement->beginTransaction();
    }




    /**
     * @inheritDoc
    */
    public function commit()
    {
        $this->statement->commit();
    }





    /**
     * @inheritDoc
    */
    public function rollback()
    {
        return $this->statement->commit();
    }




    /**
     * @inheritdoc
    */
    public function transaction(Closure $statements)
    {
        try {

            $this->beginTransaction();

            $statements($this);

            $this->commit();

        } catch (PDOException $e) {

            if ($this->getPDO()->inTransaction()) {
                $this->rollback();
            }

            $this->createConnectionException($e->getMessage());
        }
    }





    /**
     * @param null $name
     * @return int
    */
    public function lastInsertId($name = null): int
    {
        return $this->statement->lastId($name);
    }




    /**
     * @inheritDoc
    */
    public function statement($sql, array $params = []): QueryInterface
    {
          $this->statement->prepare($sql);
          $this->statement->params($params);

          return $this->statement;
    }





    /**
     * @inheritdoc
    */
    public function exec($sql): bool
    {
         return $this->statement->exec($sql);
    }






    /**
     * @param array $credentials
     * @return string
    */
    protected function makePdoDSN(array $credentials): string
    {
        if (! empty($credentials['dsn'])) {
             return $credentials['dsn'];
        }

        $dsn = sprintf('%s:host=%s;port=%s;',
               $credentials['driver'],
               $credentials['host'],
               $credentials['port']
        );

        if (isset($credentials['database'])) {
            $dsn .= "dbname={$credentials['database']};";
        }

        return $dsn;
    }




    /**
     * @param $message
     * @return void
     * @throws DriverConnectionException
    */
    protected function createDriverException($message)
    {
        throw new DriverConnectionException($message);
    }




    /**
     * @param array $credentials
     * @return void
     * @throws DriverConnectionException
    */
    protected function connectToPdo(array $credentials)
    {
          $pdo = $this->makeConnection($credentials);

          $this->setConnection($pdo);

          $this->setStatement(new Statement($pdo));
    }




    /**
     * @param array $credentials
     * @return void
     * @throws DriverConnectionException
    */
    protected function setupConnection(array $credentials)
    {
          unset($credentials['database']);
          $this->connectToPdo($credentials);
    }






    /**
     * @param array $credentials
     * @return PDO
     * @throws DriverConnectionException
     * @throws Exception
    */
    protected function makeConnection(array $credentials): PDO
    {
         return $this->makePDO($this->pdoCredentials($credentials));
    }





    /**
     * @param array $credentials
     * @return array
     * @throws DriverConnectionException
    */
    protected function pdoCredentials(array $credentials): array
    {
        if (! $this->has($name = $credentials['driver'])) {
            $this->createDriverException("Unable driver extension '{$name}' for PDO.");
        }

        $credentials['dsn'] = $this->makePdoDSN($credentials);

        return $credentials;
    }
}