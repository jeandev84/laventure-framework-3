<?php
namespace Laventure\Component\Database\Migration\Contract;


use Laventure\Component\Database\Schema\Schema;

/**
 * MigrationInterface
*/
interface MigrationInterface
{


      /**
       * Create or modify schema table
       *
       * @return mixed
      */
      public function up();







      /**
       * Drop schema table or others modification
       *
       * @return mixed
      */
      public function down();
}