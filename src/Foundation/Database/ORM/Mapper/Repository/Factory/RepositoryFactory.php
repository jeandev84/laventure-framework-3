<?php
namespace Laventure\Foundation\Database\ORM\Mapper\Repository\Factory;

use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Mapper\Repository\Factory\EntityRepositoryFactory;
use Laventure\Component\Container\Contract\ContainerInterface;
use ReflectionClass;


/**
 *
*/
class RepositoryFactory extends EntityRepositoryFactory
{

    /**
     * @var ContainerInterface
    */
    protected $app;




    /**
     * Namespace entity repository
     * 
     * @var string
    */
    protected $namespace;




    /**
     * @param ContainerInterface $app
     * @param string $namespace
    */
    public function __construct(ContainerInterface $app, string $namespace)
    {
         $this->app = $app;
         $this->namespace = $namespace;
    }




    /**
     * @return string
    */
    public function getNamespace(): string
    {
         return $this->namespace;
    }






    /**
     * @inheritDoc
    */
    public function createRepository(string $class): EntityRepository
    {
         return $this->app->get($this->make($class));
    }




    /**
     * Create entity repository name
     *
     * @param null $class
     * @return string
    */
    public function make($class): string
    {
        return (function () use ($class) {

            $entityNamespace = (new ReflectionClass($class))->getNamespaceName();

            $repositoryClass = str_replace($entityNamespace, $this->getNamespace(), $class);

            return sprintf('%sRepository', $repositoryClass);

        })();
    }

}