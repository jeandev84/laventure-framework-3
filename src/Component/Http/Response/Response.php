<?php
namespace Laventure\Component\Http\Response;


use Laventure\Component\Http\Bag\Headers\ResponseHeaderBag;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Http\Response\Contract\ResponseInterface;
use Laventure\Component\Http\Response\Utils\StatusCode;



/**
 * Response
*/
class Response implements ResponseInterface
{


      use StatusCode;


      const HTTP_OK      = 200;
      const HTTP_CREATED = 201;




      /**
       * @var string
      */
      protected $version = 'HTTP/1.0';



      /**
       * @var string
      */
      protected $content;



      /**
       * @var int
      */
      protected $statusCode;




      /**
       * @var string
      */
      protected $reasonPhrase;




      /**
       * @var array
      */
      protected $headers = [];





      /**
       * Response constructor.
       *
       * @param string|null $content
       * @param int $statusCode
       * @param array $headers
      */
      public function __construct(string $content = null, int $statusCode = 200, array $headers = [])
      {
           $this->content    = $content;
           $this->statusCode = $statusCode;
           $this->headers    = new ResponseHeaderBag($headers);
      }




      /**
       * @return string
      */
      public function getBody(): string
      {
           return (string) $this->content;
      }





      /**
       * @param string $content
       * @return $this
      */
      public function withBody(string $content): self
      {
           $this->content = $content;

           return $this;
      }




      /**
       * @return string
      */
      public function getProtocolVersion(): string
      {
           return $this->version;
      }





      /**
       * @param string $version
       * @return $this
      */
      public function withProtocolVersion(string $version): self
      {
            $this->version = $version;

            return $this;
      }




      /**
       * @inheritdoc
      */
      public function getStatusCode(): int
      {
           return $this->statusCode;
      }




      /**
       * @inheritdoc
      */
      public function getReasonPhrase(): string
      {
          return $this->reasonPhrase;
      }





      /**
       * @inheritdoc
      */
      public function withStatus($code, $reasonPhrase = null): self
      {
            $this->statusCode = $code;
            $this->reasonPhrase = $reasonPhrase;

            return $this;
      }




      /**
       * Get all headers
       *
       * @return string[]
      */
      public function getHeaders(): array
      {
          return $this->headers->all();
      }





      /**
       * @param $name
       * @param $value
       * @return $this
      */
      public function withHeaders($name, $value = null): self
      {
            $this->headers->parse($name, $value);

            return $this;
      }





      /**
       * @param $name
       * @return $this
      */
      public function withoutHeader($name): self
      {
            $this->headers->remove($name);

            return $this;
      }




      /**
       * @param $name
       * @param $value
       * @return $this
      */
      public function withAddedHeader($name, $value): self
      {
           $this->headers->merge([$name => $value]);

           return $this;
      }




      /**
       * @return bool|int
      */
      public function sendStatusMessage()
      {
           return http_response_code($this->statusCode);
      }





      /**
       * Send headers to navigator.
       *
       * @return $this
      */
      public function sendHeaders(): self
      {
           if ($this->headers->hasHeaders()) {
               foreach ($this->getHeaders() as $header) {
                   header($header);
               }
           }

           return $this;
      }





      /**
       * @return void
      */
      public function sendBody()
      {
          echo $this->__toString();
      }





      /**
       * Send status code and headers to navigator.
       *
       * @return self|void
      */
      public function send()
      {
           if (headers_sent()) {
               return $this;
           }

           $this->sendStatusMessage();
           $this->sendHeaders();
      }





      /**
       * Show object response as string
       *
       * @return string
      */
      public function __toString()
      {
           return $this->getBody();
      }




      /**
       * Convert content to array, use this case for json response
       *
       * @return array
      */
      public function toArray(): array
      {
           return [];
      }




      /**
       * @param Request $request
       * @return void
      */
      public function attach(Request $request)
      {
            $this->version = $request->getProtocolVersion();
      }
}