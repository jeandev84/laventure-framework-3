<?php
namespace Laventure\Component\Database\Migration;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Migration\Collection\MigrationCollection;
use Laventure\Component\Database\Migration\Contract\MigratorInterface;
use Laventure\Component\Database\Query\QueryBuilder;
use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\Schema;


/**
 * Migrator
*/
class Migrator implements MigratorInterface
{

        /**
         * Migrator table
         *
         * @var string
        */
        protected $table = 'migrations';




        /**
         * Schema table
         *
         * @var Schema
        */
        protected $schema;






        /**
         * @var QueryBuilder
        */
        protected $queryBuilder;




        /**
         * @var ConnectionInterface
        */
        protected $connection;





        /**
         * @var MigrationCollection
        */
        protected $migrations;





        /**
         * @param ConnectionInterface $connection
        */
        public function __construct(ConnectionInterface $connection)
        {
             $this->schema       = new Schema($connection);
             $this->migrations   = new MigrationCollection();
             $this->queryBuilder = new QueryBuilder($connection, $this->table);
             $this->connection   = $connection;
        }





        /**
         * @param $table
         * @return $this
        */
        public function table($table): self
        {
              $this->table = $table;

              $this->queryBuilder->table($table);

              return $this;
        }




        /**
         * @return string
        */
        public function getTable(): string
        {
             return $this->table;
        }





        /**
         * Add migration
         *
         * @param Migration $migration
         * @return $this
        */
        public function addMigration(Migration $migration): self
        {
             $this->migrations->add($migration);

             return $this;
        }





        /**
         * Add migration collections
         *
         * @param Migration[] $migrations
         * @return $this
        */
        public function addMigrations(array $migrations): self
        {
              $this->migrations->merge($migrations);

              return $this;
        }





        /**
         * @return MigrationCollection
        */
        public function collection(): MigrationCollection
        {
             return $this->migrations;
        }


        
        
        
        /**
         * @return array
        */
        public function getMigrations(): array
        {
             return $this->migrations->getMigrations();     
        }





        /**
         * @inheritDoc
        */
        public function install(): bool
        {
             return $this->schema->create($this->table, function (BluePrint $table) {
                   $table->increments('id');
                   $table->string('version');
                   $table->datetime('executed_at');
             });
        }




        /**
         * @return bool
        */
        public function existTable(): bool
        {
            return $this->schema->has($this->getTable());
        }




        /**
         * @inheritDoc
        */
        public function migrate()
        {
            if (! $this->existTable()) {
                $this->install();
            }

            if($migrations = $this->getMigrationsToApply()) {
                $this->upMigrations($migrations);
                return true;
            }

            return false;
        }




        /**
         * @return array
        */
        public function getMigrationsToApply(): array
        {
            return $this->migrations->diff($this->getAppliedMigrations());
        }




        /**
         * @param Migration[] $migrations
         * @return void
        */
        protected function upMigrations(array $migrations)
        {
             if (! empty($migrations)) {
                 foreach ($migrations as $migration) {
                     $this->upMigration($migration);
                 }
             }
        }




        /**
         * @param Migration $migration
         * @return false|int
         */
        protected function upMigration(Migration $migration)
        {
              $migration->up();

              return $this->queryBuilder->insert($this->attributes($migration));
        }



        /**
         * @param Migration $migration
         * @return array
        */
        protected function attributes(Migration $migration): array
        {
              return [
                  'version'     => $migration->getName(),
                  'executed_at' => (new \DateTime())->format('Y-m-d H:i:s')
              ];
        }




        /**
         * @inheritDoc
        */
        public function rollback(): bool
        {
              $this->downMigrations($this->getMigrations());

              return $this->schema->truncate($this->getTable());
        }





        /**
         * @param Migration[] $migrations
         * @return void
        */
        protected function downMigrations(array $migrations)
        {
               foreach ($migrations as $migration) {
                     $migration->down();
               }
        }



        /**
         * @inheritDoc
        */
        public function reset()
        {
             if (! $this->existTable()) {
                 return false;
             }

             $this->rollback();

             return $this->schema->dropIfExists($this->getTable());
        }





        /**
         * Remove all migrations
         * Reset migration and remove all files
         *
         * @return void
        */
        public function clear()
        {
            $this->reset();

            $this->migrations->removeMigrations();
        }




        /**
         * @return void
        */
        public function refresh()
        {
             $this->reset();

             $this->migrate();
        }






        /**
         * Get executed migrations
         *
         * @inheritDoc
        */
        public function getAppliedMigrations()
        {
              return $this->queryBuilder
                          ->select([$this->versionColumn()])
                          ->from($this->getTable())
                          ->fetch()
                          ->columns();
        }





        /**
          * @return string
        */
        protected function versionColumn(): string
        {
              return 'version';
        }
}