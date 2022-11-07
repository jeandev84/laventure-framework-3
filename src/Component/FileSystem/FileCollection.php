<?php
namespace Laventure\Component\FileSystem;


/**
 * FileCollection
*/
class FileCollection
{

      /**
       * @var File[]
      */
      protected $files = [];




      /**
       * @var string[]
      */
      protected $paths = [];




      /**
       * @var array
      */
      protected $items  = [];




      /**
       * FileCollection constructor
       *
       * @param array $files
      */
      public function __construct(array $files)
      {
           $this->addFiles($files);
      }




      /**
       * Add new file object
       *
       * @param File $file
       * @return $this
      */
      public function add(File $file): self
      {
           $this->files[$file->filename()] = $file;
           $this->paths[$file->filename()] = $file->path();
           $this->items[$file->filename()] = $file->config();

           return $this;
      }





      /**
       * Add files
       *
       * @param array $files
       * @return void
      */
      public function addFiles(array $files)
      {
          foreach ($files as $file) {
              $this->add(new File($file));
          }
      }





      /**
       * Get files collection
       *
       * @return File[]
      */
      public function files(): array
      {
           return $this->files;
      }





      /**
       * @return string[]
      */
      public function paths(): array
      {
          return $this->paths;
      }




      /**
       * Get data files by name
       *
       * @return array
      */
      public function configs(): array
      {
           return $this->items;
      }




      /**
       * Return file names
       *
       * @return array
      */
      public function names(): array
      {
           return array_keys($this->files());
      }
}