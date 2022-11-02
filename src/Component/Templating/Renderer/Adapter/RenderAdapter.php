<?php
namespace Laventure\Component\Templating\Renderer\Adapter;

use Laventure\Component\Templating\Renderer\Compressor\RenderCompressor;
use Laventure\Component\Templating\Renderer\Layout\RenderLayoutInterface;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Renderer\RendererInterface;


/**
 * @class RenderAdapter
*/
class RenderAdapter
{

      /**
       * @var RendererInterface
      */
      protected $renderer;




      /**
       * @var RenderCompressor
      */
      protected $compressor;






      /**
       * @var bool
      */
      protected $compressed = false;






      /**
       * @param RendererInterface $renderer
      */
      public function __construct(RendererInterface $renderer)
      {
            $this->renderer   = $renderer;
            $this->compressor = new RenderCompressor();
      }




      /**
       * @param $path
       * @return void
      */
      public function cachePath($path)
      {
           if ($this->renderer instanceof Renderer) {
                $this->renderer->cachePath($path);
           }
      }




      /**
        * @param bool $compressed
        * @return void
      */
      public function compress(bool $compressed)
      {
            $this->compressed = $compressed;
      }







      /**
       * @param $layout
       * @return $this
      */
      public function layout($layout): RenderAdapter
      {
           if ($this->renderer instanceof RenderLayoutInterface) {
               $this->renderer->withLayout($layout);
           }

           return $this;
      }






      /**
       * @param $template
       * @param array $arguments
       * @return void
      */
      public function includePath($template, array $arguments)
      {
            if ($this->renderer instanceof Renderer) {
                 $this->renderer->includePath($template, $arguments);
            }
      }





      /**
       * @param $template
       * @param array $arguments
       * @return mixed
      */
      public function render($template, array $arguments = [])
      {
           $content = $this->renderer->render($template, $arguments);

           if ($this->compressed) {
                return $this->compressor->compress($content);
           }

           return $content;
      }
}