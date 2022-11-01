<?php
namespace Laventure\Component\Database\Migration\Contract;


use Laventure\Component\Database\Schema\Schema;


/**
 * IMigration
*/
interface IMigration
{


      /**
       * Create or modify schema table
       *
       * @return mixed
      */
      public function up(Schema $schema);







      /**
       * Drop schema table or others modification
       *
       * @return mixed
      */
      public function down(Schema $schema);
}