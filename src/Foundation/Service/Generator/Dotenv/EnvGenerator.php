<?php
namespace Laventure\Foundation\Service\Generator\Dotenv;

use Laventure\Foundation\Service\Generator\FileGenerator;
use Laventure\Foundation\Service\Generator\StubGenerator;


/**
 * Envgenerator
*/
class EnvGenerator extends StubGenerator
{

      /**
       * @return string
      */
      public function generateEnvFile(): string
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
           $env = "{$key}={$value}";
           $previousContent = $this->fs()->read('.env');
           $newContent      = preg_replace("/{$key}=(.*)/", $env, $previousContent);
           $this->remove('.env');
           return $this->generate('.env', $newContent);
      }
}