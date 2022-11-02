<?php
namespace Laventure\Foundation\Service\Generator;

/**
 * ClassGenerator
*/
class ClassGenerator extends StubGenerator
{


    /**
     * @param array $credentials
     * @return string|null
    */
    public function generateClass(array $credentials): ?string
    {
        $class          = $credentials['DummyClass'] ?? 'DummyClass';
        $dummyPath      = $credentials['DummyPath']  ?? 'DummyPath';
        $targetPath     = $this->generatePath($dummyPath, sprintf('%s.php', $class));
        $dummyNamespace = $credentials['DummyNamespace'] ?? 'DummyNamespace';

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