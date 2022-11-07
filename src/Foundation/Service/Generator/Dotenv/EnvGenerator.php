<?php
namespace Laventure\Foundation\Service\Generator\Dotenv;

use Laventure\Foundation\Service\Generator\File\StubGenerator;


/**
 * Envgenerator
*/
class EnvGenerator extends StubGenerator
{

      /**
       * @return string
      */
      public function generateEnv(): string
      {
           $stub = $this->readStub('env/template.stub');

           return $this->generate('.env', $stub);
      }





      /**
       * @param $key
       * @param $value
       * @return string|null
      */
      public function generateKey($key, $value): ?string
      {
           $previous = $this->fs()->read('.env'); // previous content
           $content  = preg_replace("/{$key}=(.*)/", "{$key}={$value}", $previous); // new content
           $this->remove('.env');
           return $this->generate('.env', $content); // generate new content
      }
}