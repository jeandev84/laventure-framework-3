<?php
namespace Laventure\Component\Templating\Renderer\Layout;

interface RenderLayoutInterface
{

      /**
       * @param $layout
       * @return mixed
      */
      public function withLayout($layout);






     /**
      * Render Layout content
      *
      * @return mixed
     */
     public function renderLayout();
}