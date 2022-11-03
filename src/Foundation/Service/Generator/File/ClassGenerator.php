<?php
namespace Laventure\Foundation\Service\Generator\File;

/**
 * ClassGenerator
*/
class ClassGenerator extends StubGenerator
{



    /**
     * @var array
     */
    protected $config = [];




    /**
     * @param array $config
     * @return void
    */
    public function configs(array $config)
    {
        $this->config = $config;
    }




    /**
     * @param $name
     * @return mixed|null
    */
    public function config($name)
    {
         return $this->config[$name] ?? $name;
    }





    /**
     * @param array $credentials
     * @return string|null
    */
    public function generateClass(array $credentials): ?string
    {
        $class          = $credentials['DummyClass'];
        $dummyPath      = $this->config('DummyPath');
        $targetPath     = $this->generatePath($dummyPath, sprintf('%s.php', $class));
        $dummyNamespace = $this->config('DummyNamespace');

        [$dummyNamespace, $class]       = $this->resolveClassNamespace($dummyNamespace, $class);
        $credentials['DummyNamespace']  = $dummyNamespace;
        $credentials['DummyClass']      = $class;

        if (empty($credentials['DummyStubPath'])) {
             $this->createGeneratorException("DummyStubPath undefined. Try to set it please.");
        }

        $dummyStubPath = $credentials['DummyStubPath'];

        $stub = $this->generateStub($dummyStubPath, $credentials);

        return $this->generate($targetPath, $stub);
    }





    /**
     * @param $namespace
     * @param $class
     * @return array
    */
    private function resolveClassNamespace($namespace, $class): array
    {
        $prefixes   = explode('/', $class);
        $className  = ucfirst(end($prefixes));
        $module     = str_replace($className, '', implode('\\', $prefixes));
        $module     = $module ? '\\'. rtrim(ucfirst($module), '\\') : '';
        $namespace .= $module;

        return [$namespace, $className];
    }





    /**
     * @param $basePath
     * @param $template
     * @return string
    */
    public function generatePath($basePath, $template): string
    {
        $basePath  = trim($basePath, '\\/');
        $template = trim($template, "\\/");

        return sprintf('%s/%s', $basePath, $template);
    }
}