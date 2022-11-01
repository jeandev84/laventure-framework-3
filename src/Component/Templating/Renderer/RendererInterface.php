<?php
namespace Laventure\Component\Templating\Renderer;


/**
 * RendererInterface
*/
interface RendererInterface
{

    /**
     * @param $template
     * @param array $arguments
     * @return mixed
    */
    public function render($template, array $arguments = []);
}