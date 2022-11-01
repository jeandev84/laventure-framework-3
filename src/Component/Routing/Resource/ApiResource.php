<?php
namespace Laventure\Component\Routing\Resource;



use Laventure\Component\Routing\Resource\Common\Resource;
use Laventure\Component\Routing\Resource\Types\ResourceType;

/**
 *
*/
class ApiResource extends Resource
{
    /**
     * @inheritDoc
    */
    public function getType(): string
    {
        return ResourceType::API;
    }


    /**
     * @inheritDoc
    */
    protected static function configureRoutes(): array
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
                'methods' => ['POST'],
                'path'    => '/store',
                'action'  => 'store'
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