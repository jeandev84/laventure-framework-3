<?php
namespace Laventure\Foundation\Http\Resource\Json;

use Laventure\Component\Http\Request\Request;

class JsonResource
{

      /**
       * @var Request
      */
      protected $request;




      /**
       * @param Request $request
      */
      public function __construct(Request $request)
      {
           $this->request = $request;
      }





      /**
       * @param $request
       * @return array
      */
      public function toArray($request): array
      {
           return [
               'id'   => 1,
               'date' => date('Y-m-d H:i:s')
           ];
      }





      /**
       * @param $name
       * @return mixed|null
      */
      public function __get($name)
      {
           if (! $this->request->request->has($name)) {
                return null;
           }

           return $this->request->request->get($name);
      }
}