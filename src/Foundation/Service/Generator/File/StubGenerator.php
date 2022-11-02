<?php
namespace Laventure\Foundation\Service\Generator\File;


use Laventure\Component\FileSystem\FileSystem;


/**
 * StubGenerator
*/
class StubGenerator extends FileGenerator
{


    /**
     * @var array
    */
    protected $replacements = [];



    /**
     * @param array $replacements
     * @return void
    */
    public function replacements(array $replacements)
    {
         $this->replacements = $replacements;
    }





     /**
      * @return string
     */
     protected function stubPath(): string
     {
          return realpath(__DIR__ . '/stubs/');
     }




     /**
      * @param $template
      * @param $replacements
      * @return string
     */
     public function generateStub($template, $replacements): string
     {
         $replacements['GenerateTime']    =  date('d/m/Y H:i:s');
         $replacements['ApplicationName'] =  app()->getName();

         $template = sprintf('%s.%s', trim($template, "\\/"), $this->stubExtension());

         $replacements = array_merge($this->replacements, $replacements);

         return $this->stub()->replace($template, $replacements);
     }






     /**
      * @param $template
      * @return false|string
     */
     public function readStub($template)
     {
         return $this->stub()->read(sprintf("%s.%s", trim($template, "\\/"), $this->stubExtension()));
     }





     /**
      * @param $template
      * @return string
     */
     public function locateStub($template): string
     {
         $extension = $this->stub()->file($template)->extension();

         $template = (str_replace($extension, '', trim($template, "\\/")));

         return $this->stub()->locate(sprintf('%s.%s', $template, $this->stubExtension()));
     }





     /**
      * @return FileSystem
     */
     public function stub(): FileSystem
     {
          $filesystem = parent::fs();
          $filesystem->root($this->stubPath());
          return $filesystem;
     }




     /**
      * @return string
     */
     public function stubExtension(): string
     {
          return 'stub';
     }
}