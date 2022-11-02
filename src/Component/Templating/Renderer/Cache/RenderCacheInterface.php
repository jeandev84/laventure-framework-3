<?php
namespace Laventure\Component\Templating\Renderer\Cache;


/**
 * @class RenderCacheInterface
*/
interface RenderCacheInterface
{
     /**
      * Cache content
      *
      * @param $template
      * @param $content
      * @return mixed
    */
    public function cache($template, $content);
}