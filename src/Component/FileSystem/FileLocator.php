<?php
namespace Laventure\Component\FileSystem;


/**
 * FileLocator
*/
class FileLocator
{

       /**
        * Base directory
        *
        * @var string
       */
       protected $root;


        /**
         * FileLocator constructor.
         *
         * @param $root
       */
       public function __construct($root)
       {
           $this->root($root);
       }




       /**
         * @param $root
         * @return void
       */
       public function root($root)
       {
            $this->root = $this->resolveBasePath($root);
       }




       /**
        * @return string
       */
       public function basePath(): string
       {
            return $this->root;
       }




       /**
        * @param string $path
        * @return string
       */
       public function locate(string $path): string
       {
           $destination = $this->root . DIRECTORY_SEPARATOR . $this->resolvePath($path);

           return ! $this->root ? $path : $destination;
       }




       /**
        * @param string $pattern
        * @param int $flags
        * @return array|false
       */
       public function locateResources(string $pattern, int $flags = 0)
       {
            return glob($this->locate($pattern), $flags);
       }



       /**
        * @param string $path
        * @return string
       */
       public function resolvePath(string $path): string
       {
             return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, trim($path, '\\/'));
       }





       /**
        * @param $root
        * @return string
       */
       public function resolveBasePath($root): string
       {
            return (string) rtrim($root, '\\/');
       }
}