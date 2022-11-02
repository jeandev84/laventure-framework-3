<?php
namespace Laventure\Component\Templating;

interface TemplateInterface
{


      /**
       * @param $path
       * @return mixed
      */
      public function withPath($path);





      /**
       * @param $data
       * @return mixed
      */
      public function withParameters($data);





      /**
       * @return mixed
      */
      public function render();
}