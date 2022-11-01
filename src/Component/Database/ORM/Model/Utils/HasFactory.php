<?php
namespace Laventure\Component\Database\ORM\Model\Utils;

trait HasFactory
{

     protected $credentials = [];


    /**
      * @param array $credentials
      * @return void
     */
     public function factory(array $credentials)
     {
           $this->credentials = $credentials;
     }
}