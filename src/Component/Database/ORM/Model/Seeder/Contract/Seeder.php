<?php
namespace Laventure\Component\Database\ORM\Model\Seeder\Contract;

abstract class Seeder
{
     /**
      * Run seeder
      *
      * @return mixed
     */
     abstract public function run();
}