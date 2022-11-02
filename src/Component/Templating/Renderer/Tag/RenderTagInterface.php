<?php
namespace Laventure\Component\Templating\Renderer\Tag;

use Traversable;

interface RenderTagInterface
{

     /**
      * @param array|Traversable $contentTags
      * @return mixed
     */
     public function withTags($contentTags);




     /**
      * @param $content
      * @return mixed
     */
     public function replaceTags($content);
}