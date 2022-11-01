<?php
namespace Laventure\Component\FileSystem;


use Closure;
use Exception;
use Laventure\Component\FileSystem\Exception\StreamException;

/**
 *
*/
class Stream
{

      /**
       * @var
      */
      protected $path;




      /**
       * @param string $path
      */
      public function __construct(string $path)
      {
          $this->path = $path;
      }




      /**
       * @param string $mode
       * @return false|resource
      */
      public function open(string $mode): bool
      {
           return fopen($this->path, $mode);
      }




      /**
       * @param $stream
       * @return bool
      */
      public function close($stream): bool
      {
          return fclose($stream);
      }



      /**
       * Write to the file using stream
       *
       * @param $data
       * @param string $mode
       * @return bool
       * @throws StreamException
      */
      public function write($data, string $mode = 'a'): bool
      {
           try {

               $stream = $this->open($mode);

               fwrite($stream, $data);

               return $this->close($stream);

           } catch (Exception $e) {

               throw new StreamException($e->getMessage());
           }
      }




      /**
       * Read file using stream
       *
       * @param int $length
       * @param string $mode
       * @return bool
       * @throws StreamException
      */
      public function read(int $length, string $mode = 'r'): bool
      {
          try {

              $stream = $this->open($mode);

              fread($stream, $length);

              return $this->close($stream);

          } catch (Exception $e) {

              throw new StreamException($e->getMessage());
          }
      }
}