<?php
namespace Laventure\Component\Http\Bag\Headers;

use Laventure\Component\Http\Bag\HeaderBag;


/**
 * RequestHeaderBag
*/
class RequestHeaderBag extends HeaderBag
{
      /**
       * Request headers
      */
      public function __construct()
      {
          parent::__construct(getallheaders());
      }




      /**
       * Return content type
       *
       * @return mixed
      */
      public function contentType()
      {
           return $this->get('Content-Type');
      }




      /**
       * Determine if the content type from form url encoded
       *
       * @return bool
      */
      public function formEncoded(): bool
      {
           return stripos($this->contentType(), 'application/x-www-form-urlencoded') === 0;
      }
}