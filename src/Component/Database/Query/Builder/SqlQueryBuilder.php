<?php
namespace Laventure\Component\Database\Query\Builder;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;
use Laventure\Component\Database\Query\Builder\SQL\SqlBuilder;


/**
 * SqlQueryBuilder
*/
abstract class SqlQueryBuilder implements SqlQueryBuilderInterface
{

       /**
        * @var ConnectionInterface
       */
       protected $connection;



       /**
        * @var string
       */
       protected $classMap;



       /**
        * SqlQueryBuilder construct.
        *
        * @param ConnectionInterface $connection
       */
       public function __construct(ConnectionInterface $connection)
       {
              $this->connection = $connection;
       }



       /**
        * @param $class
        * @return void
       */
       public function mapClass($class)
       {
             $this->classMap = $class;
       }



       /**
        * @param array $selects
        * @param string $table
        * @return Select
       */
       public function selectQuery(array $selects, string $table): Select
       {
           return $this->resolveCommandSQL(new Select($selects, $table));
       }




       /**
         * @param $table
         * @return Delete
       */
       public function deleteQuery($table): Delete
       {
            return $this->resolveCommandSQL(new Delete($table));
       }




       /**
        * @param array $attributes
        * @param string $table
        * @return Insert
       */
       public function insertQuery(array $attributes, string $table): Insert
       {
            return $this->resolveCommandSQL(new Insert($attributes, $table));
       }




       /**
        * @param array $attributes
        * @param string $table
        * @return Update
       */
       public function updateQuery(array $attributes, string $table): Update
       {
             return $this->resolveCommandSQL(new Update($attributes, $table));
       }



       /**
         * @param SqlBuilder $builder
         * @return mixed
       */
       public function resolveCommandSQL(SqlBuilder $builder)
       {
              $builder->connection($this->connection);

              if ($builder instanceof Select && $this->classMap) {
                  $builder->mapClass($this->classMap);
              }

              return $builder;
       }
}