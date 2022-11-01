<?php
namespace Laventure\Component\Templating\Asset;


/**
 * @Asset
 */
class Asset implements AssetInterface
{

    /**
     * @var string
     */
    protected $url;



    /**
     * @var array
     */
    protected $styles = [];



    /**
     * @var array
     */
    protected $scripts = [];



    const EXT_STYLE   = 'css';
    const EXT_SCRIPT  = 'js';




    /**
     * Asset constructor
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
         $this->baseURL($url);
    }



    /**
     * @param string $url
     * @return $this
     */
    public function baseURL(string $url): self
    {
        $this->url = rtrim($url, '\\/');

        return $this;
    }




    /**
     * Add css link
     *
     * @param string $style
    */
    public function css(string $style)
    {
        $this->styles[] = $style;
    }



    /**
     * @param array $styles
    */
    public function addStyles(array $styles)
    {
        $this->styles = array_merge($this->styles, $styles);
    }





    /**
     * Get css data
     *
     * @return array
    */
    public function getStyles(): array
    {
        return $this->styles;
    }




    /**
     * Add js link
     *
     * @param string $script
    */
    public function js(string $script)
    {
        $this->scripts[] = $script;
    }





    /**
     * @param array $scripts
    */
    public function addScripts(array $scripts)
    {
        $this->scripts = array_merge($this->scripts, $scripts);
    }





    /**
     * Get css data
     *
     * @return array
    */
    public function getScripts(): array
    {
        return $this->scripts;
    }




    /**
     * Render asset path
     *
     * Example : asset('/css/app.css')
     * Example : asset('/css/app.js')
     * Example : asset('/uploads/thumbs/some_hash.jpg')
     *
     * @param string $path
     * @return string
    */
    public function link(string $path): string
    {
        return $this->url . '/' . trim($path, '\\/');
    }




    /**
     * @param array $files
     * @return string
    */
    public function links(array $files = []): string
    {
        if (! $files) {
            return implode(array_merge([$this->renderStyles(), $this->renderScripts()]));
        }

        return $this->renderBoth($files);
    }




    /**
     * @param string $filename
     * @return string
    */
    public function renderStyle(string $filename): string
    {
        $filename = $this->to($filename);

        if (! $this->isStyle($filename)) {
            return "";
        }

        return sprintf('<link href="%s" rel="stylesheet">', $filename);
    }





    /**
     * @return string
     */
    public function renderStyles(): string
    {
        $templates = [];

        foreach ($this->styles as $filename) {
            $templates[] = $this->renderStyle($filename);
        }

        return join("\n", $templates);
    }




    /**
     * @param string $filename
     * @return string
     */
    public function renderScript(string $filename): string
    {
        $filename = $this->to($filename);

        if (! $this->isScript($filename)) {
            return "";
        }

        return sprintf('<script src="%s" type="application/javascript"></script>', $filename);
    }




    /**
     * @return string
     */
    public function renderScripts(): string
    {
        $templates = [];

        foreach ($this->scripts as $filename) {
            $templates[] = $this->renderScript($filename);
        }

        return join("\n", $templates);
    }




    /**
     * @param array $files
     * @return string
    */
    public function renderBoth(array $files): string
    {
        $assets = [];

        foreach ($files as $filename) {
            if ($this->isStyle($filename)) {
                $assets[] = $this->renderStyle($filename);
            }elseif ($this->isScript($filename)) {
                $assets[] = $this->renderScript($filename);
            }
        }

        return implode($assets);
    }




    /**
     * @param string $filename
     * @return bool
    */
    protected function isScript(string $filename): bool
    {
        return $this->getExtension($filename) === self::EXT_SCRIPT;
    }




    /**
     * @param string $filename
     * @return bool
    */
    protected function isStyle(string $filename): bool
    {
        return $this->getExtension($filename) === self::EXT_STYLE;
    }



    /**
     * @param string $filename
     * @return array|string|string[]
    */
    protected function getExtension(string $filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

}