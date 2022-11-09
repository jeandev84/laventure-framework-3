<?php
namespace Laventure\Component\Templating\Renderer\Tag;


/**
 * RenderTag
*/
class RenderTag implements RenderTagInterface
{

      /**
       * @var array
      */
      protected $tags = [];





      /**
       * TagRender
      */
      public function __construct()
      {
           $this->withTags($this->defaultTags());
      }





      /**
       * @inheritdoc
      */
      public function replaceTags($content): string
      {
           return (string) str_replace($this->searchs(), $this->replaces(), $content);
      }





      /**
       * @param $contentTags
       * @return void
      */
      public function withTags($contentTags)
      {
           $this->tags = array_merge($this->tags, $contentTags);
      }





      /**
       * @return string[]
      */
      private function defaultTags(): array
      {
          return [
              '{%'        =>  "<?php ",
              '%}'        =>  ";?>",
              '{{'        =>  "<?=",
              '}}'        =>  ";?>",
              '@if'       =>  "<?php if",
              '@endif'    =>  "<?php endif; ?>",
              '@loop'     =>  "<?php foreach",
              '):'        =>  "): ?>",
              '@endloop'  =>  "<?php endforeach; ?>",
          ];
      }





      /**
       * @return array
      */
      private function searchs(): array
      {
           return array_keys($this->tags);
      }




      /**
       * @return array
      */
      private function replaces(): array
      {
           return array_values($this->tags);
      }
}