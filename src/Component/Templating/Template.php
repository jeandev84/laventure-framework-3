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
     * @param $path
     * @param array $data
    */
    public function __construct($path, array $data = [])
    {
          $this->path = $path;
          $this->data = $data;
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

        if (! $this->exist()) {
            $this->createException("Template file {$this->path} does not exist.");
        }

        ob_start();
        require $this->path;
        return ob_get_clean();
    }





    /**
     * @return bool
    */
    public function exist(): bool
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