<?php
namespace Laventure\Foundation\Service\Generator\ORM\Mapper;


use Laventure\Foundation\Service\Generator\File\ClassGenerator;


/**
 * EntityRepositoryGenerator
*/
class EntityRepositoryGenerator extends ClassGenerator
{


    /**
     * @param $name
     * @return string|null
    */
    public function generateRepository($name): ?string
    {
         $credentials["DummyClass"]   = str_replace('Repository', '', $name);
         [$entityNamespace, $entityClass] = $this->resolveEntityNamespace($credentials["DummyClass"]);

         $credentials = array_merge([
              "DummyStubPath"   => "database/orm/mapper/repository/template",
              "DummyClass"      => sprintf("%sRepository", $credentials["DummyClass"]),
              "EntityNamespace" => $entityNamespace,
              "EntityClass"     => $entityClass
         ]);

         return $this->generateClass($credentials);
    }




    /**
     * @param $className
     * @return array
    */
    private function resolveEntityNamespace($className): array
    {
        $namespace = trim($this->config("EntityNamespace"), "\\");
        $entityNamespace = sprintf("%s\\%s", $namespace, $className);
        $entityNamespace = str_replace("/", '\\', $entityNamespace);
        $entityParts     = explode("\\", $entityNamespace);
        $entityClass     = end($entityParts);

        return [$entityNamespace, $entityClass];
    }
}