<?php
namespace Laventure\Foundation\Service\Generator\Http;

use Laventure\Foundation\Service\Generator\StubGenerator;



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
     * @param array $credentials
     * @return string
    */
    public function generateActions(array $credentials): string
    {
        if (empty($credentials['DummyActions'])) {
             return "";
        }

        $controllerPath = $credentials['DummyClass'] ?: "Dummy";

        $actionStubs = [];

        foreach ($credentials['DummyActions'] as $action) {

            $resource = $this->generateResourcePath($controllerPath, $action);

            $actionStubs[] = $this->generateStub($this->actionStubPath(), [
                'DummyActionName' => $action,
                'DummyViewPath'   => $resource
            ]);

            $this->resources[] = $resource;
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







    /**
     * @return string
    */
    protected function actionStubPath(): string
    {
         return 'http/action/web/template';
    }
}