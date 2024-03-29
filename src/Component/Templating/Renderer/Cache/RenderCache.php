<?php
namespace Laventure\Component\Templating\Renderer\Cache;



/**
 * RenderCacheManager
*/
class RenderCache implements RenderCacheInterface
{

      /**
       * @var string
      */
      private $cachePath;



      
      /**
       * @param $path
      */
      public function __construct($path)
      {
           $this->cachePath($path);
      }




      /**
       * @param $path
       * @return void
      */
      public function cachePath($path)
      {
           $this->cachePath = rtrim($path, '\\/');
      }




      /**
       * @return string
      */
      public function getCachePath(): string
      {
           return $this->cachePath;
      }



      /**
       * @inheritdoc
      */
      public function cache($template, $content)
      {
           $dirname = pathinfo($template, PATHINFO_DIRNAME);

           if (! is_dir($dirname)) {
               mkdir($dirname, 0777, true);
           }

           return touch($template) ? file_put_contents($template, $content) : false;
      }





      /**
       * @param $template
       * @param $content
       * @return false|int
      */
      public function cacheTemplate($template, $content)
      {
           return $this->cache($this->locateTemplateCache($template), $content);
      }




      /**
       * @param $template
       * @return string
      */
      public function locateTemplateCache($template): string
      {
           return $this->locateCache($template);
      }



      /**
       * @param $template
       * @return string
      */
      public function locateCache($template): string
      {
           return implode(DIRECTORY_SEPARATOR, [$this->getCachePath(), md5($template). '.php']);
      }




      /**
       * @param $template
       * @return void
      */
      public function removePreviousCache($template)
      {
           @unlink($this->locateCache($template));
      }



      /**
       * @return void
      */
      public function removeAllPreviousCache()
      {
           array_map('unlink', glob($this->getCachePath() . "/*"));
      }




      /**
       * @param $template
       * @return bool
      */
      public function existCache($template): bool
      {
           return file_exists($this->locateCache($template));
      }
}