<?php
namespace Laventure\Foundation\Factory\Views;

use Laventure\Component\Templating\Renderer\Adapter\RenderAdapter;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Renderer\RendererInterface;


/**
 * ViewFactory
*/
class ViewFactory
{


       const TWIG   = 'twig';
       const BLADE  = 'blade';




       /**
        * @var string[]
       */
       private static $extensions = [self::TWIG, self::BLADE];





       /**
        * @param $root
        * @param $extension
        * @return RenderAdapter
      */
      public static function create($root, $extension): RenderAdapter
      {
            $renderer = new Renderer($root);

            return new RenderAdapter($renderer);
      }
}