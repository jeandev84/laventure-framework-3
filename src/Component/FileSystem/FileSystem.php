<?php
namespace Laventure\Component\FileSystem;

/**
 * FileSystem
*/
class FileSystem
{

       /**
        * @var FileLocator
       */
       protected $locator;




       /**
        * FileSystem constructor.
        *
        * @param $root
       */
       public function __construct($root = null)
       {
             $this->locator = new FileLocator($root);
       }




       /**
        * Set base directory
        *
        * @param string|null $root
        * @return void
       */
       public function root(string $root)
       {
            $this->locator->root($root);
       }





       /**
        * Reset root and adding subdirectory
        *
        * @param $path
        * @return void
       */
       public function rootTo($path)
       {
            $path = $this->locate($path);

            $this->root($path);
       }




       /**
        * @return string
       */
       public function basePath(): string
       {
            return $this->locator->basePath();
       }




       /**
        * Locate file by given path
        *
        * @param string $path
        * @return string
       */
       public function locate(string $path): string
       {
           return $this->locator->locate($path);
       }




       /**
        * Locate files by given pattern
        *
        * @param string $pattern
        * @return array|false
       */
       public function resources(string $pattern)
       {
           return $this->locator->locateResources($pattern);
       }





       /**
        * Return object File which contains all methods for manage file
        *
        * @param string $path
        * @return File
       */
       public function file(string $path): File
       {
            return new File($this->locate($path));
       }




       /**
        * Load Path
        *
        * @param string $path
        * @return false|mixed
       */
       public function load(string $path)
       {
            return $this->file($path)->loadPath();
       }







       /**
        * Determine if given file name exist
        *
        * @param string $path
        * @return bool
       */
       public function exists(string $path): bool
       {
            return $this->file($path)->exists();
       }





       /**
        * Remove given file name
        *
        * @param string $path
        * @return bool
       */
       public function remove(string $path): bool
       {
            return $this->file($path)->remove();
       }





       /**
        * Return object FileCollection for management collection files.
        *
        * @param string $pattern
        * @return FileCollection
       */
       public function collection(string $pattern): FileCollection
       {
            return new FileCollection($this->resources($pattern));
       }





       /**
        * Put contents to the given file name
        *
        * @param $filename
        * @param $content
        * @param bool $append
        * @return false|int
       */
       public function write($filename, $content, bool $append = false)
       {
            return $this->file($filename)->write($content, $append);
       }






       /**
        * Return file contents
        *
        * @param $filename
        * @return false|string
       */
       public function read($filename)
       {
            return $this->file($filename)->read();
       }






       /**
        * Upload file
        *
        * @param string $target
        * @param string $filename
        * @return bool|null
       */
       public function move(string $target, string $filename): ?bool
       {
            return $this->file($target)->move($this->locate($filename));
       }





       /**
         * Copy file to given destination
         *
         * @param string $from
         * @param string $destination
         * @param $context
         * @return bool
       */
       public function copy(string $from, string $destination, $context = null): bool
       {
            return $this->file($from)->copy($this->locate($destination), $context);
       }




       /**
        * @param string $template
        * @param array $replacements
        * @return string
       */
       public function replace(string $template, array $replacements): string
       {
           return $this->file($template)->replace($replacements);
       }



       /**
        * @param string $path
        * @return Stream
       */
       public function stream(string $path): Stream
       {
            return new Stream($this->locate($path));
       }
}