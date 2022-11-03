<?php
namespace Laventure\Foundation\Service\Generator\Migration;


class MigrationModelGenerator extends MigrationGenerator
{

      public function generateMigrationClass($table): ?string
      {
          $credentials = array_merge([
              "DummyStubPath"     => "database/migration/template",
              "DummyClass"        => 'create_users_table', // add_column_demo_to_users_table,,
              "tableName"         => $table
          ]);

          return $this->generateClass($credentials);
      }
}