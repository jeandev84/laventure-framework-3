<?php
namespace Laventure\Component\Http\Response;


/**
 * JsonResponse
*/
class JsonResponse extends Response
{

       /**
        * @param array $data
        * @param int $statusCode
        * @param array $headers
       */
       public function __construct(array $data, int $statusCode = 200, array $headers = [])
       {
             $content = $this->toJson($data);
             $headers = $this->jsonHeaders($headers);

             parent::__construct($content, $statusCode, $headers);
       }




       /**
        * json_decode(json|string, associate|bool, depth|int, flags|int...)
        *
        * @inheritdoc
       */
       public function toArray(): array
       {
            return json_decode($this->content, true);
       }




       /**
        * @return int
       */
       protected function decodeDepth(): int
       {
           return 512;
       }




       /**
        * @return string
       */
       protected function decodeFlags(): string
       {
           return implode('|', [
                0
           ]);
       }




       /**
        * @return string
       */
       protected function encodeFlags(): string
       {
            return implode('|', [
                JSON_PRETTY_PRINT
            ]);
       }





       /**
        * @param array $data
        * @return false|string
       */
       private function toJson(array $data)
       {
           return \json_encode($data, $this->encodeFlags());
       }




       /**
        * @param array $headers
        * @return string[]
       */
       private function jsonHeaders(array $headers = []): array
       {
           return array_merge([
               'Content-Type' => 'application/json'
           ], $headers);
       }
}