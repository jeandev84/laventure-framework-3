<?php
namespace Laventure\Foundation\Service\Generator\Migration;


use Laventure\Foundation\Service\Generator\ClassGenerator;


/**
 * MigrationGenerator
*/
class MigrationGenerator extends ClassGenerator
{
      /**
       * @param array $credentials
       * @return string|null
      */
      public function generateMapperMigrationClass(array $credentials): ?string
      {
            $credentials = array_merge([
                 "DummyStubPath"     => "database/migration/template",
                 "DummyNamespace" => "App\\Migration",
                 "DummyClass"     => sprintf('Version%s', date('YmdHis')),
                 "DummyPath"      => "app/Migration",
                 "tableName"      => 'demo'
            ], $credentials);

            return $this->generateClass($credentials);
      }




      /**
       * @param array $credentials
       * @return string|null
      */
      public function generateModelMigrationClass(array $credentials): ?string
      {
          $credentials = array_merge([
              "DummyStubPath"  => "database/migration/template",
              "DummyNamespace" => "Database\\Migrations",
              "DummyClass"     => 'create_users_table', // add_column_demo_to_users_table,
              "DummyPath"      => "database/migrations",
              "tableName"      => 'demo'
          ], $credentials);

          return $this->generateClass($credentials);
      }
}