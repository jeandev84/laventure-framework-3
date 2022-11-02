<?php
namespace Laventure\Foundation\Service\Generator\Controller;

use Laventure\Foundation\Service\Generator\File\StubGenerator;


/**
 * @class ActionGenerator
*/
class ActionGenerator extends StubGenerator
{

    /**
     * @var array
    */
    protected $resources = [];


    /**
     * @param array $actions
     * @param array $options
     * @return string
    */
    public function generateActions(array $actions, array $options = []): string
    {
        if (empty($actions)) {
             return "";
        }

        $actionStubs    = [];
        $controllerPath = $options['DummyControllerPath'] ?: 'Dummy';

        foreach ($actions as $action) {
            $actionStubs[] = $this->generateStub("controller/action/template", array_merge([
                'DummyActionName' => $action
            ], $options));

            $this->resources[] = $this->generateResourcePath($controllerPath, $action);
        }

        return implode("\n\n", $actionStubs);
    }




    /**
     * @return array
    */
    public function getResources(): array
    {
          return $this->resources;
    }





    /**
     * @param $controllerPath
     * @param $actionPath
     * @return string
    */
    public function generateResourcePath($controllerPath, $actionPath): string
    {
         $controllerPath = str_replace('Controller', '', $controllerPath);

         return sprintf('%s/%s', strtolower($controllerPath), $actionPath);
    }
}