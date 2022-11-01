<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;


use Laventure\Foundation\Service\Generator\ClassGenerator;


/**
 * EntityRepositoryGenerator
*/
class EntityRepositoryGenerator extends ClassGenerator
{


    /**
     * @param array $credentials
     * @return string|null
    */
    public function generateRepository(array $credentials): ?string
    {
         $credentials["DummyClass"]       = str_replace('Repository', '', $credentials["DummyClass"]);
         [$entityNamespace, $entityClass] = $this->resolveEntityNamespace($credentials["DummyClass"]);

         $credentials = array_merge([
              "DummyNamespace"  => "App\\Repository",
              "DummyClass"      => sprintf("%sRepository", $credentials["DummyClass"]),
              "DummyPath"       => "app/Repository",
              "EntityNamespace" => $entityNamespace,
              "EntityClass"     => $entityClass
         ]);

         return $this->generateClass($credentials);
    }




    /**
     * @inheritDoc
    */
    protected function dummyStubPath(): string
    {
         return 'database/orm/mapper/template/repository';
    }




    /**
     * @param $className
     * @return array
    */
    private function resolveEntityNamespace($className): array
    {
        $entityNamespace = sprintf("App\\Entity\\%s", $className);
        $entityNamespace = str_replace("/", '\\', $entityNamespace);
        $entityParts     = explode("\\", $entityNamespace);
        $entityClass     = end($entityParts);

        return [$entityNamespace, $entityClass];
    }
}