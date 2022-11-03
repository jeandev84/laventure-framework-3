<?php
namespace Laventure\Foundation\Service\Generator\Migration;


use Laventure\Foundation\Service\Generator\File\ClassGenerator;


/**
 * MigrationGenerator
*/
class MigrationGenerator extends ClassGenerator
{
      /**
       * @param $table
       * @return string|null
      */
      public function generateMigrationClass($table): ?string
      {
            $credentials = array_merge([
                 "DummyStubPath"     => "database/migration/template",
                 "DummyClass"        => sprintf('Version%s', date('YmdHis')),
                 "tableName"         => $table
            ]);

            return $this->generateClass($credentials);
      }
}