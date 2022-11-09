<?php
namespace Laventure\Component\Routing\Resolver;

use Laventure\Component\Routing\Group\RouteGroup;


/**
 *
*/
class RouteResolver
{

       /**
        * Current Route group
        *
        * @var RouteGroup
       */
       protected $group;



       /**
        * Controller namespace
        *
        * @var string
       */
       protected $namespace;






       /**
        * RouteResolver constructor.
       */
       public function __construct()
       {
            $this->group = new RouteGroup();
       }





       /**
        * @param string $prefix
        * @return void
       */
       public function prefix(string $prefix)
       {
            $this->group->prefix($prefix);
       }





       /**
        * @param $module
        * @return void
       */
       public function module($module)
       {
           $this->group->module($module);
       }






       /**
        * @param $middleware
        * @return void
       */
       public function middleware($middleware)
       {
             $this->group->middlewares($middleware);
       }





       /**
         * @param string $name
         * @return void
       */
       public function name(string $name)
       {
            $this->group->name($name);
       }






       /**
        * Set group
        *
        * @param RouteGroup $group
        * @return $this
       */
       public function attachGroup(RouteGroup $group): self
       {
             $this->group = $group;

             return $this;
       }





       /**
        * @return void
       */
       public function removePrefixes()
       {
            $this->group->refresh();
       }




       /**
        * Set Controller Namespace
        *
        * @param string $namespace
        * @return $this
       */
       public function namespace(string $namespace): self
       {
             $this->namespace = $namespace;

             return $this;
       }




       /**
        * @param $methods
        * @return array
       */
       public function resolveMethods($methods): array
       {
            if (is_string($methods)) {
                $methods = explode('|', $methods);
            }

            return (array) $methods;
       }




       /**
        * @param string $path
        * @return string
       */
       public function resolvePath(string $path): string
       {
            if ($prefix = $this->group->getPrefix()) {
                $path = sprintf('%s/%s', $prefix, ltrim($path, '/'));
            }

            return $path;
       }




       /**
        * @param $action
        * @return array|mixed
       */
       public function resolveAction($action)
       {
           if ($this->isStringAction($action)) {
               $action = explode('@', $action, 2);
               return [$this->getController($action[0]), $action[1]];
           }

           return $action;
       }




       /**
        * @param string $name
        * @return string
       */
       public function getController(string $name): string
       {
           return sprintf('%s\\%s', $this->getNamespace(), $name);
       }






       /**
        * @return string
       */
       public function getNamespace(): string
       {
            if (! $this->namespace) {
                return '';
            }

            if ($module = $this->group->getModule()) {
                $module = sprintf('\\%s', $module);
            }

            return sprintf('%s%s', $this->namespace, $module);
       }



       /**
        * @param array $attributes
        * @return array
       */
       public function refreshGroupAttributes(array $attributes): array
       {
            return array_merge($this->getGroupAttributes(), $attributes);
       }





       /**
        * @return RouteGroup
       */
       public function getGroup(): RouteGroup
       {
           return $this->group;
       }



       /**
        * @return array
       */
       public function getGroupAttributes(): array
       {
            return $this->group->getAttributes();
       }



       /**
        * @param $action
        * @return bool
       */
       protected function isStringAction($action): bool
       {
           return is_string($action) && stripos($action, '@') !== false;
       }
}