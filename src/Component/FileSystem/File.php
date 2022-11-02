<?php
namespace Laventure\Component\FileSystem;


/**
 * File
*/
class File
{



       /**
        * File path
        *
        * @var string
       */
       protected $path;





       /**
        * File constructor.
        *
        * @param string $path
       */
       public function __construct(string $path)
       {
            $this->path = $path;
       }




       /**
        * Get directory name
        *
        * @return string
       */
       public function dirname(): string
       {
            return $this->info(PATHINFO_DIRNAME);
       }





       /**
        * Get base name
        *
        * @return string
       */
       public function basename(): string
       {
            return $this->info(PATHINFO_BASENAME);
       }




       /**
        * Get file name
        *
        * @return string
       */
       public function filename(): string
       {
           return $this->info(PATHINFO_FILENAME);
       }




       /**
        * Get file extension
        *
        * @return string
       */
       public function extension(): string
       {
            return $this->info(PATHINFO_EXTENSION);
       }




       /**
        * Get file size
        *
        * @return false|int
       */
       public function size()
       {
            return filesize($this->path);
       }





       /**
        * Get full path of file
        *
        * @return string
       */
       public function path(): string
       {
            return $this->path;
       }




       /**
        * Get file infos
        *
        * @param int|null $needle
        * @return array|string
       */
       public function info(int $needle = null)
       {
            return $needle ? (string) pathinfo($this->path, $needle) : pathinfo($this->path);
       }




       /**
        * Get real path relative for OS
        *
        * @return false|string
       */
       public function realpath()
       {
            return realpath($this->path);
       }




       /**
        * Determine if file exist
        *
        * @return bool
       */
       public function exists(): bool
       {
           return file_exists($this->path);
       }




       /**
        * Determine if file exist and is regular file
        *
        * @return bool
       */
       public function isRegular(): bool
       {
            return is_file($this->path);
       }





       /**
        * Determine if file is executable
        *
        * @return bool
       */
       public function isExecutable(): bool
       {
           return is_executable($this->path);
       }





       /**
        * Determine if file is readable
        *
        * @return bool
       */
       public function isReadable(): bool
       {
            return is_readable($this->path);
       }




       /**
        * Determine if file is writable
        *
        * @return bool
       */
       public function isWritable(): bool
       {
            return is_writable($this->path);
       }



       /**
        * Make file directory
        *
        * @param string|null $dirname
        * @return bool
       */
       public function mkdir(string $dirname = null): bool
       {
            if (! $dirname) {
                 $dirname = $this->dirname();
            }

            if (! \is_dir($dirname)) {
                return @mkdir($dirname, 0777, true);
            }

            return true;
       }






       /**
        * Make file
        *
        * @return bool
       */
       public function make(): bool
       {
            $this->mkdir();

            return touch($this->path);
       }




       /**
        * @return mixed
       */
       public function loadPath()
       {
            if (! $this->exists()) {
                 return false;
            }

           return require($this->realpath());
       }




       /**
        * Load file content array data
        *
        * @return array
       */
       public function loadArray(): array
       {
            if (! $this->exists() || ! is_array($data = require $this->path)) {
                return [];
            }

            return $data;
       }




       /**
        * @return array|false
       */
       public function contentToArray()
       {
            return file($this->realpath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
       }





       /**
        * Load file content array data and encode to json
        *
        * @return false|string
       */
       public function contentToJson()
       {
            return json_encode($this->loadArray(), JSON_PRETTY_PRINT);
       }




       /**
        * @return array|false
       */
       public function scan()
       {
            if (! is_dir($this->path)) {
                 return false;
            }

            return scandir($this->path);
       }




       /**
        * Upload file
        *
        * @param string $filename
        * @return bool
       */
       public function move(string $filename): bool
       {
            $this->mkdir();

            return move_uploaded_file($this->path, $filename);
       }




       /**
        * Copy file to destination
        *
        * @param string $destination
        * @param $context
        * @return bool
       */
       public function copy(string $destination, $context = null): bool
       {
            return copy($this->path, $destination, $context);
       }




       /**
         * Remove file
         *
         * @param null $context
         * @return bool
       */
       public function remove($context = null): bool
       {
            return @unlink($this->path, $context);
       }




       /**
        * Put content to file
        *
        * @param string $content
        * @param int $flags
        * @param $context
        * @return false|int
       */
       public function put(string $content, int $flags = 0, $context = null)
       {
            $this->make();

            return file_put_contents($this->path, $content, $flags, $context);
       }





       /**
        * Get file content by given context
        *
        * @param $include_path
        * @param $context
        * @param $offset
        * @param $length
        * @return false|string
       */
       public function get($include_path = null, $context = null, $offset = null, $length = null)
       {
            return file_get_contents($this->path, $include_path, $context, $offset,  $length);
       }





       /**
        * Write content to current file
        *
        * @param string $content
        * @param bool $append
        * @return false|int
       */
       public function write(string $content, bool $append = false)
       {
             if ($append) {
                 return $this->put($content . PHP_EOL, FILE_APPEND | LOCK_EX);
             }

             return $this->put($content);
       }




       /**
        * Rewrite into file
        *
        * @param string $newContext
        * @return false|int
       */
       public function rewrite(string $newContext)
       {
            $this->remove();

            return $this->write($newContext);
       }





       /**
        * Read current file
        *
        * @return false|string
       */
       public function read()
       {
           return $this->get();
       }




       /**
        * Replace parameters in content file
        *
        * @param array $replacements
        * @return string
       */
       public function replace(array $replacements): string
       {
            $search  = array_keys($replacements);
            $replace = array_values($replacements);

            return (string) str_replace($search, $replace, $this->read());
       }




       /**
        * Dump data from base64 encoding
        *
        * @param string $base64
        * @return false|int
       */
       public function dump(string $base64)
       {
             $this->make();

             return $this->write(base64_decode($base64));
       }



       /**
        * @param $path
        *  @return string
       */
       public function resolvePath($path): string
       {
            $path = str_replace(["\\", '/'], DIRECTORY_SEPARATOR, $path);

            return trim($path, "\\/");
       }
}