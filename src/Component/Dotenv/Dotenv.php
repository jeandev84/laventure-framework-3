<?php
namespace Laventure\Component\Dotenv;


/**
 * Dotenv
*/
class Dotenv
{


     /**
      * @var static
     */
     protected static $instance;




     /**
      * @var string
     */
     protected $root;




     /**
      * @var Env
     */
     protected $env;




     /**
      * Dotenv constructor.
      *
      * @param string $root
     */
     public function __construct(string $root)
     {
          $this->root = $root;
          $this->env  = new Env();
     }




     /**
      * @param $root
      * @return static
     */
     public static function create($root): self
     {
          if (! static::$instance) {
              static::$instance = new static($root);
          }

          return static::$instance;
     }




     /**
      * @param string $filename
      * @return bool
     */
     public function load(string $filename = '.env'): bool
     {
          if ($environs = $this->loadEnvironments($filename)) {
               $this->env->load($environs);
               return true;
          }

          return false;
     }




     /**
      * @param string $filename
      * @return array
     */
     public function loadEnvironments(string $filename): array
     {
          if(! $filename = $this->path($filename)) {
                return [];
          }

          return file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     }





     /**
      * @param string $filename
      * @return false|string
     */
     public function path(string $filename)
     {
          return realpath($this->root . DIRECTORY_SEPARATOR . $filename);
     }
}