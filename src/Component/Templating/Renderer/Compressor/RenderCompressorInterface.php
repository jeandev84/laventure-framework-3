<?php
namespace Laventure\Component\Templating\Renderer\Compressor;

interface RenderCompressorInterface
{
    /**
     * Compress view content
     *
     * @param $content
     * @return mixed
    */
    public function compress($content);
}