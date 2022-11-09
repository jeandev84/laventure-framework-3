<?php
namespace Laventure\Component\Templating\Renderer;


use Laventure\Component\Templating\Renderer\Cache\RenderCache;
use Laventure\Component\Templating\Renderer\Compressor\RenderCompressor;
use Laventure\Component\Templating\Renderer\Layout\RenderLayoutInterface;
use Laventure\Component\Templating\Renderer\Tag\RenderTag;
use Laventure\Component\Templating\Template;



/**
 * Renderer
*/
class Renderer implements RendererInterface, RenderLayoutInterface
{


    /**
     * @var string
    */
    private $root;




    /**
     * @var string
    */
    private $layout;




    /**
     * @var string
    */
    private $extension = 'tpl.php';




    /**
     * @var RenderCache
    */
    private $cache;





    /**
     * @var RenderTag
    */
    private $contentTag;





    /**
     * @param $root
    */
    public function __construct($root = null)
    {
          $this->basePath($root);
          $this->cache      = new RenderCache($root);
          $this->contentTag = new RenderTag();
    }






    /**
     * @param string $root
     * @return $this
    */
    public function basePath(string $root): self
    {
         $this->root = rtrim($root, '\\/');

         return $this;
    }





    /**
     * @param string $path
     * @return void
    */
    public function cachePath(string $path)
    {
         $this->cache->cachePath($path);
    }






     /**
      * Return view extension
      *
      * @return string
     */
     public function getExtension(): string
     {
         return $this->extension;
     }






    /**
     * @param $layout
     * @return $this
    */
    public function withLayout($layout): self
    {
         $this->layout = $layout;

         return $this;
    }





    /**
     * @return string
    */
    public function getLayout(): string
    {
         return $this->layout;
    }





    /**
     * @inheritDoc
    */
    public function render($template, array $arguments = [])
    {
         $content = $this->renderTemplate($this->locate($template));

         if ($this->layout) {
              $content = $this->wrap($content);
         }

         return $this->renderCache($template, $content, $arguments);
    }





    /**
     * @param $path
     * @param array $arguments
     * @return false|string
    */
    public function renderTemplate($path, array $arguments = [])
    {
         return (new Template($path, $arguments))->render();
    }



    

    /**
     * @param $content
     * @return string
    */
    public function wrap($content): string
    {
         $content = PHP_EOL. $content . PHP_EOL;

         return (string) str_replace("{{ content }}", $content, $this->renderLayout());
    }







    /**
     * Locate template path
     *
     * @param string $path
     * @return string
    */
    public function locate(string $path): string
    {
         return $this->root . DIRECTORY_SEPARATOR . $this->resolvePath($path);
    }




    /**
     * @param $template
     * @param $content
     * @param $arguments
     * @return string
    */
    public function renderCache($template, $content, $arguments): string
    {
          $content = $this->contentTag->replaceTags($content);

          if (! $this->cache->cacheTemplate($template, $content)) {
              $this->cacheTemplateException($template);
          }

          $cachePath = $this->cache->locateTemplateCache($template);

          return $this->renderTemplate($cachePath, $arguments);
    }





    /**
     * @param string $template
     * @param array $data
     * @return mixed
    */
    public function includePath(string $template, array $data = [])
    {
         $content = $this->renderTemplate($this->locate($template), $data);

         $content = $this->contentTag->replaceTags($content);

         if (! $this->cache->cacheTemplate($template, $content)) {
              $this->cacheTemplateException($template);
         }

         return @include $this->cache->locateTemplateCache($template);
    }





    /**
     * @inheritdoc
    */
    public function renderLayout()
    {
         return $this->renderTemplate($this->locate($this->layout));
    }





    /**
     * @param string $message
     * @return mixed
    */
    public function abortIf(string $message)
    {
        return (function () use ($message) {
            throw new RenderException($message);
        })();
    }




    /**
     * @param $template
     * @return void
    */
    private function cacheTemplateException($template)
    {
          $this->abortIf("Something went wrong during caching {$this->locate($template)}");
    }




    /**
     * @param $path
     * @return string
    */
    private function resolvePath($path): string
    {
        $path = str_replace('.'. $this->getExtension(), '', $path);
        $path = trim($path, "\\/");
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);

        return sprintf('%s.%s', $path, $this->getExtension());
    }
}