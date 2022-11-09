<?php
namespace Laventure\Component\Http\Request;


use Laventure\Component\Http\Bag\Headers\RequestHeaderBag;
use Laventure\Component\Http\Bag\InputBag;
use Laventure\Component\Http\Bag\ParameterBag;
use Laventure\Component\Http\Message\StreamInterface;
use Laventure\Component\Http\Request\Contract\UriInterface;
use Laventure\Component\Http\Session\Session;


/**
 * Request
*/
class Request extends ServerRequest
{


      /**
       * Headers bag
       *
       * @var RequestHeaderBag
      */
      protected $headers;




      /**
       * Request method
       *
       * @var string
      */
      protected $method;




      /**
       * Target request URL
       *
       * @var string
      */
      protected $requestTarget;




      /**
       * Object request URI
       *
       * @var Uri
      */
      public $uri;




      /**
       * Parsed content
       *
       * @var string
      */
      public $content;




      /**
       * Session manager
       *
       * @var Session
      */
      protected $sessions;




      /**
       * @var StreamInterface
      */
      protected $body;






      /**
       * @param array $queries
       * @param array $request
       * @param array $attributes
       * @param array $cookies
       * @param array $files
       * @param array $server
       * @param string|null $content
     */
     public function __construct(
         array $queries = [],
         array $request = [],
         array $attributes = [],
         array $cookies = [],
         array $files = [],
         array $server = [],
         string $content = null
     )
     {
           parent::__construct($queries, $request, $attributes, $cookies, $files, $server);

           $this->uri      = new Uri($this->server);
           $this->sessions = new Session();
           $this->headers  = new RequestHeaderBag();
           $this->content  = $content;
     }





     /**
       * Create a request
       *
       * @return static
     */
     public static function create(
         array $queries = [],
         array $request = [],
         array $attributes = [],
         array $cookies = [],
         array $files = [],
         array $server = []
     ): ServerRequest
     {
          return new static($queries, $request, $attributes, $cookies, $files, $server);
     }





     /**
      * Create request from globals variables
      *
      * @return static
     */
     public static function fromGlobals(): self
     {
          $request = static::factory($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER, 'php://input');

          if ($request->parsed()) {
              parse_str($request->getContent(), $data);
              $request->request = new InputBag($data);
          }

          return $request;
     }






     /**
      * Create request from factory
      *
      * @return static
     */
     public static function factory(
         array $queries = [],
         array $request = [],
         array $attributes = [],
         array $cookies = [],
         array $files = [],
         array $server = [],
         string $content = null
     ): self
     {
          return new static($queries, $request, $attributes, $cookies, $files, $server, $content);
     }





     /**
      * @param UriInterface $uri
      * @param bool $preserveHost
      * @return $this
     */
     public function withUri(UriInterface $uri, bool $preserveHost = false): self
     {
          $this->uri = $uri;

          return $this;
     }





     /**
      * @return UriInterface
     */
     public function getUri(): UriInterface
     {
          return $this->uri;
     }





     /**
      * @param $version
      * @return $this
     */
     public function withProtocolVersion($version): self
     {
           $this->server->set('SERVER_PROTOCOL', $version);

           return $this;
     }





     /**
      * @param $name
      * @return bool
     */
     public function hasHeader($name): bool
     {
          return $this->headers->has($name);
     }




     /**
      * @param $name
      * @return mixed
     */
     public function getHeader($name)
     {
          return $this->headers->get($name);
     }





     /**
      * @param $name
      * @return mixed
     */
     public function getHeaderLine($name)
     {
           // todo implements
           return null;
     }




     /**
      * Set request headers
      *
      * @param array|string $name
      * @param $value
      * @return $this
     */
     public function withHeader($name, $value): self
     {
          $this->headers->parse($name, $value);

          return $this;
     }





     /**
      * @param $name
      * @param $value
      * @return $this
     */
     public function withAddedHeader($name, $value): self
     {
          $this->headers->set($name, $value);

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
      * @param StreamInterface $body
      * @return $this
     */
     public function withBody(StreamInterface $body): self
     {
            $this->body = $body;

            return $this;
     }





     /**
      * @param $method
      * @return $this
     */
     public function withMethod($method): self
     {
          $this->server->set('REQUEST_METHOD', $method);

          $this->method = $method;

          return $this;
     }





     /**
      * @param $requestTarget
      * @return $this
     */
     public function withRequestTarget($requestTarget): self
     {
            $this->requestTarget = $requestTarget;

            return $this;
     }





     /**
      * Get all request headers
      *
      * @return array
     */
     public function getHeaders(): array
     {
          return $this->headers->all();
     }





     /**
      * string
      *
      * @return string
     */
     public function getContent(): string
     {
          return file_get_contents($this->content);
     }





     /**
      * @return string
     */
     public function getRequestTarget(): string
     {
          return $this->decodeURL($this->requestTarget);
     }






     /**
      * @return StreamInterface
     */
     public function getBody(): StreamInterface
     {
           return $this->body;
     }






     /**
      * @return string
     */
     public function getMethod(): string
     {
          return $this->method ?: $this->server->method();
     }






     /**
      * @return string
     */
     public function getRequestUri(): string
     {
          return $this->decodeURL($this->server->requestUri());
     }





     /**
      * @return string
     */
     public function getProtocolVersion(): string
     {
          return $this->server->protocolVersion();
     }




     /**
      * @return bool
     */
     public function secure(): bool
     {
          return $this->server->isSecure();
     }





     /**
      * Return IP address
      *
      * @return string
     */
     public function ip(): string
     {
          return "";
     }





     /**
      * Return params sent by all request methods .
      *
      * @param string|null $name
      * @return mixed
     */
     public function input(string $name = null)
     {
          if (! $this->request instanceof InputBag) {
               return false;
          }

          return $this->params($name);
     }






      /**
       * Returns request params
       *
       * @param string|null $name
       * @param null $default
       * @return mixed
      */
      public function params(string $name = null, $default = null)
      {
           foreach ($this->configParams() as $methods => $parameter) {
                if (in_array($this->getMethod(), explode('|', $methods))) {
                      return $name ? $parameter->get($name, $default) : $parameter->all();
                }
           }

           return null;
      }






      /**
       * Determine if the request is method GET
       *
       * @return bool
      */
      public function get(): bool
      {
           return $this->server->isMethod('get');
      }





      /**
       * Determine if the request is method POST
       *
       * @return bool
     */
     public function post(): bool
     {
          return $this->server->isMethod('post');
     }





     /**
      * Determine if the request is method PUT
      *
      * @return bool
     */
     public function put(): bool
     {
          return $this->server->isMethod('put');
     }






     /**
      * Determine if the request is method DELETE
      *
      * @return bool
     */
     public function delete(): bool
     {
          return $this->server->isMethod('delete');
     }





     /**
      * Determine if the request is method XMLHttpRequest
      *
      * @return bool
     */
     public function ajax(): bool
     {
          return $this->server->isXhr();
     }






     /**
      * @return bool
     */
     public function parsed(): bool
     {
         return $this->hasFormEncoded() && $this->hasResourceMethods();
     }





     /**
      * Determine if the given host name is valid
      *
      * @param string $host
      * @return bool
     */
     public function validHost(string $host): bool
     {
           return $this->server->isValidHost($host);
     }







     /**
      * @return string
     */
     public function baseURL(): string
     {
          return $this->decodeURL($this->server->baseURL());
     }





     /**
      * @return string
     */
     public function url(): string
     {
          return $this->decodeURL($this->server->url());
     }





     /**
      * @param $path
      * @return string
     */
     public function encodeURL($path): string
     {
          return urlencode((string)$path);
     }





     /**
      * @param $path
      * @return string
     */
     public function decodeURL($path): string
     {
          return urldecode((string)$path);
     }





     /**
      * @return bool
     */
     protected function hasResourceMethods(): bool
     {
          return $this->server->hasResourceMethods(['PUT', 'DELETE', 'PATCH']);
     }






     /**
      * @return bool
     */
     protected function hasFormEncoded(): bool
     {
         return $this->headers->formEncoded();
     }



     /**
      * @return ParameterBag[]
     */
     private function configParams(): array
     {
          return [
             'POST|PUT|DELETE|PATCH' => $this->request,
             'GET'                   => $this->queries
          ];
     }
}