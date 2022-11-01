<?php
namespace Laventure\Component\Templating;


/**
 * Template
*/
class Template implements TemplateInterface
{


    /**
     * @var string
    */
    protected $path;




    /**
     * @var array
    */
    protected $data = [];




    /**
     * @param string|null $path
     * @param array $data
    */
    public function __construct(string $path = null, array $data = [])
    {
         $this->withPath($path);
         $this->withParameters($data);
    }





    /**
     * @inheritDoc
    */
    public function withPath($path): self
    {
         $this->path = $path;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function withParameters($data): self
    {
         $this->data = $data;

         return $this;
    }






    /**
     * @inheritDoc
    */
    public function render()
    {
        extract($this->data, EXTR_SKIP);

        if (! $this->existTemplate()) {
            $this->createException("Template file {$this->path} does not exist.");
        }

        ob_start();
        require $this->path;
        return ob_get_clean();
    }





    /**
     * @return bool
    */
    public function existTemplate(): bool
    {
         return is_file($this->path);
    }




    /**
     * @return string
    */
    public function __toString()
    {
         return $this->render();
    }





    /**
     * @param string $message
     * @return mixed
    */
    public function createException(string $message)
    {
         return (function () use ($message) {
              throw new TemplateException($message);
         })();
    }
}