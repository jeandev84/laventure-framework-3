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
     * @param FileSystem $filesystem
    */
    public function __construct(FileSystem $filesystem)
    {
         $this->filesystem = $filesystem;
    }




    /**
     * @param $targetPath
     * @param $content
     * @return string|null
    */
    public function generate($targetPath, $content): ?string
    {
        if ($this->generated($targetPath)) {
             $this->createGeneratorException("File '{$targetPath}' already generated.");
        }

        if(! $this->fs()->write($targetPath, $content)) {
            return null;
        }

        return $targetPath;
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