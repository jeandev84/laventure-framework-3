<?php
namespace Laventure\Component\Http\Bag\Headers;


use Laventure\Component\Http\Bag\HeaderBag;


/**
 *
*/
class ResponseHeaderBag extends HeaderBag
{

     /**
      * ResponseHeaderBag
     */
     public function __construct(array $params = [])
     {
          $previousHeaders = headers_list();

          parent::__construct(array_merge($previousHeaders, $params));
     }





     /**
      * @return array
     */
     public function all(): array
     {
         $headers = [];

         foreach ($this->params as $key => $value) {
             $headers[] = is_int($key) ? $value : sprintf('%s: %s', $key, $value);
         }

         return $headers;
     }




     /**
      * @return array
     */
     public function removePreviousHeaders(): array
     {
          // todo finish implementation where remove all previous headers.

          $previousHeaders = $this->all();

          $headers = [];

          foreach ($previousHeaders as $header) {
              [$name, $value] = explode(':', $header, 2);
              $headers[$name] = $value;
          }

          return $headers;
     }






    /**
     * @return void
    */
    public function removeHeaders()
    {
        parent::removeHeaders();

        header_remove();
    }




    /**
     * @param $key
     * @return void
     */
    public function removeHeader($key)
    {
        parent::removeHeader($key);

        header_remove($key);
    }





    /**
     * @return bool
    */
    public function sent(): bool
    {
        return headers_sent();
    }
}