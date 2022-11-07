<?php
namespace Laventure\Component\Database\ORM\Model\Seeder;

use Laventure\Component\Database\ORM\Model\Seeder\Contract\Seeder;

class SeederManager
{

     /**
      * @var Seeder[]
     */
     protected $seeders = [];





     /**
      * @param Seeder $seeder
      * @return $this
     */
     public function addSeeder(Seeder $seeder): self
     {
         $this->seeders[] = $seeder;

         return $this;
     }





     /**
      * @param Seeder[] $seeds
      * @return void
     */
     public function addSeeders(array $seeds)
     {
          foreach ($this->seeders as $seeder) {
               $this->addSeeder($seeder);
          }
     }





     /**
      * Run all seeders
      *
      * @return void
     */
     public function run()
     {
          foreach ($this->seeders as $seeder) {
               $seeder->run();
          }
     }
}