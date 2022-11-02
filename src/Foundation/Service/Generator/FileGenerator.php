<?php
namespace Laventure\Foundation\Service\Generator;


use Laventure\Component\FileSystem\FileSystem;


/**
 * FileGenerator
*/
class FileGenerator
{

    /**
     * @var FileSystem
    */
    private $filesystem;




    /**
     * @var string[]
    */
    private $message = [];





    /**
     * @param FileSystem $filesystem
    */
    public function __construct(FileSystem $filesystem)
    {
         $this->filesystem = $filesystem;
    }


    /**
     * Generate new file if that is not exist
     *
     * @param $targetPath
     * @param $content
     * @return false|mixed
    */
    public function generate($targetPath, $content)
    {
        if ($this->generated($targetPath)) {
            $this->createGeneratorException("File '$targetPath' already generated.");
        }

        if(! $this->fs()->write($targetPath, $content)) {
            return false;
        }

        return $targetPath;
    }




    /**
     * @return string[]
    */
    public function getMessages(): array
    {
         return $this->message;
    }





    /**
     * Write to existent file ( Append new content to file )
     *
     * @param $targetPath
     * @param $content
     * @return false|int
    */
    public function writeTo($targetPath, $content)
    {
         return $this->fs()->write($targetPath, $content, true);
    }






    /**
     * @param $filename
     * @return bool
    */
    public function generated($filename): bool
    {
         return $this->fs()->exists($filename);
    }





    /**
     * @param $targetPath
     * @return bool
    */
    public function remove($targetPath): bool
    {
         return $this->fs()->file($targetPath)->remove();
    }





    /**
     * @param $template
     * @return string
    */
    public function locate($template): string
    {
         return $this->fs()->locate($template);
    }




    /**
     * @return FileSystem
    */
    public function fs(): FileSystem
    {
         $this->filesystem->root(base_path());

         return $this->filesystem;
    }





    /**
     * @param $message
     * @return mixed
    */
    public function createGeneratorException($message)
    {
         return (function () use ($message) {
               throw new FileGeneratorException($message);
         })();
    }
}