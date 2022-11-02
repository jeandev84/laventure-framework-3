<?php
namespace Laventure\Component\Templating\Renderer\Compressor;


/**
 * @class RenderCompressor
*/
class RenderCompressor implements RenderCompressorInterface
{

    /**
     * @var string[]
    */
    protected $search =  [
        "/(\n)+/",
        "/\r\n+/",
        "/\n(\t)+/",
        "/\n(\ )+/",
        "/\>(\n)+</",
        "/\>\r\n</",
    ];



    /**
     * @var string[]
    */
    protected $replace = [
        "\n",
        "\n",
        "\n",
        "\n",
        '><',
        '><',
    ];




    /**
     * @inheritdoc
    */
    public function compress($content)
    {
        return preg_replace($this->search, $this->replace, $content);
    }
}