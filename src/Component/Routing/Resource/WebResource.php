<?php
namespace Laventure\Component\Routing\Resource;


use Laventure\Component\Routing\Resource\Common\Resource;
use Laventure\Component\Routing\Resource\Types\ResourceType;


/**
 *
*/
class WebResource extends Resource
{

    /**
     * @inheritDoc
    */
    public function getType(): string
    {
         return ResourceType::WEB;
    }



    /**
     * @inheritDoc
    */
    protected function configureRoutes(): array
    {
         return [
            [
                'methods' => ['GET'],
                'path'    => '',
                'action'  => 'index'
            ],
            [
                 'methods' => ['GET'],
                 'path'    => '/{parameter}',
                 'action'  => 'show'
            ],
            [
                 'methods' => ['GET'],
                 'path'    => '/create',
                 'action'  => 'create'
            ],
            [
                 'methods' => ['POST'],
                 'path'    => '/store',
                 'action'  => 'store'
            ],
            [
                 'methods' => ['GET'],
                 'path'    => '/{parameter}/edit',
                 'action'  => 'edit'
            ],
            [
                 'methods' => ['PUT'],
                 'path'    => '/{parameter}',
                 'action'  => 'update'
            ],
            [
                 'methods' => ['DELETE'],
                 'path'    => '/{parameter}',
                 'action'  => 'destroy'
            ]
         ];
    }
}