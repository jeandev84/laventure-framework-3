<?php
namespace Laventure\Foundation\Service\Generator;

/**
 * ClassGenerator
*/
abstract class ClassGenerator extends StubGenerator
{


    /**
     * @param array $credentials
     * @return string|null
    */
    public function generateClass(array $credentials): ?string
    {
        $class          = $credentials['DummyClass'] ?? 'DummyClass';
        $dummyPath      = $credentials['DummyPath']  ?? 'DummyPath';
        $targetPath     = $this->generatePath($dummyPath, $class);
        $dummyNamespace = $credentials['DummyNamespace'] ?? 'DummyNamespace';

        [$dummyNamespace, $class]       = $this->resolveClassNamespace($dummyNamespace, $class);
        $credentials['DummyNamespace']  = $dummyNamespace;
        $credentials['DummyClass']      = $class;

        $stub = $this->generateStub($this->dummyStubPath(), $credentials);

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
     * @param $classname
     * @return string
    */
    public function generatePath($basePath, $classname): string
    {
        $basePath  = trim($basePath, '\\/');
        $classname = trim($classname, "\\/");

        return sprintf('%s/%s.php', $basePath, $classname);
    }



    /**
     * @return string
    */
    abstract protected function dummyStubPath(): string;
}