<?php
namespace Laventure\Component\Templating\Renderer;


/**
 * RenderTag
*/
class RenderTag
{

      /**
       * @var array
      */
      protected $contentTags = [];





      /**
       * TagRender
      */
      public function __construct()
      {
           $this->add($this->defaultContentTags());
      }




      /**
       * @param $content
       * @return string
      */
      public function make($content): string
      {
           return (string) str_replace($this->searchs(), $this->replaces(), $content);
      }





      /**
       * @param array $tags
       * @return void
      */
      public function add(array $tags)
      {
           $this->contentTags = array_merge($this->contentTags, $tags);
      }





      /**
       * @return string[]
      */
      private function defaultContentTags(): array
      {
          return [
              '{%'        =>  "<?php ",
              '%}'        =>  ";?>",
              '{{'        =>  "<?=",
              '}}'        =>  ";?>",
              '@if'       =>  "<?php if",
              '@endif'    =>  "<?php endif; ?>",
              '@loop'     =>  "<?php foreach",
              '@endloop'  =>  "<?php endforeach; ?>",
          ];
      }





      /**
       * @return array
      */
      private function searchs(): array
      {
           return array_keys($this->contentTags);
      }




      /**
       * @return array
      */
      private function replaces(): array
      {
           return array_values($this->contentTags);
      }
}