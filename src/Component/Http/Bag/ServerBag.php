<?php
namespace Laventure\Component\Http\Bag;


/**
 * ServerBag
*/
class ServerBag extends ParameterBag
{

     /**
      * @param string $url
      * @param bool $associative
      * @param $context
      * @return array|false
     */
     public function getHostHeaders(string $url = '', bool $associative = true, $context = null)
     {
         return get_headers($url ?? $this->host(), $associative, $context);
     }





     /**
      * @return array
     */
     public function getHeaders(): array
     {
         $headers = [];

         foreach ($this->params as $key => $value) {
             if(strpos($key, 'HTTP_') === 0) {
                 $headers[substr($key, 5)] = $value;
             } elseif (\in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'], true)) {
                 $headers[$key] = $value;
             }
         }

         return $headers;
     }


     /**
      * @return mixed|null
     */
     public function httpReferer()
     {
          return $this->get('HTTP_REFERER');
     }




     /**
      * Return string request URI
      *
      * @return mixed
     */
     public function requestUri()
     {
          return $this->get('REQUEST_URI');
     }






     /**
      * Returns path document root
      *
      * @return mixed
     */
     public function documentRoot()
     {
         return $this->get('DOCUMENT_ROOT');
     }





     /**
      * Returns server protocol version
      *
      * @return mixed
     */
     public function protocolVersion()
     {
         return $this->get('SERVER_PROTOCOL');
     }





     /**
      * Returns path info
      *
      * @return mixed
     */
     public function pathInfo()
     {
         return $this->get('PATH_INFO');
     }




     /**
      * Returns query string
      *
      * @return mixed
     */
     public function queryString()
     {
         return $this->get('REQUEST_QUERY');
     }






     /**
      * Returns HTTP Host
      *
      * @return mixed
     */
     public function host()
     {
          return $this->get('HTTP_HOST');
     }






     /**
      * Returns server port
      *
      * @return mixed
     */
     public function port()
     {
         return $this->get('SERVER_PORT');
     }






    /**
     * Returns request method
     *
     * @param string $default
     * @return string
     */
     public function method(string $default = 'GET'): string
     {
          return strtoupper($this->get('REQUEST_METHOD', $default));
     }




     /**
      * Returns authenticated username credentials
      *
      * @return mixed|null
     */
     public function username()
     {
         return $this->get('PHP_AUTH_USER');
     }





     /**
      * Returns authenticated password credentials
      *
      * @return mixed
     */
     public function password()
     {
         return $this->get('PHP_AUTH_PW');
     }




     /**
      * Return protocol scheme
      *
      * @return string
      */
     public function scheme(): string
     {
         return $this->isSecure() ? 'https' : 'http';
     }





     /**
      * Returns request base URL
      *
      * @return string
     */
     public function baseURL(): string
     {
         return sprintf('%s://%s%s',
                $this->scheme(),
                $this->authCredentials(),
                $this->host()
         );
     }





     /**
      * Return full path request URL
      *
      * @return string
     */
     public function url(): string
     {
         return sprintf('%s%s', $this->baseURL(), $this->requestUri());
     }





     /**
      * @return bool
     */
     public function isHttps(): bool
     {
           return $this->has('HTTPS') || $this->isForwardedProto();
     }





    /**
     * Determine if the HTTP protocol is secure
     * @return bool
    */
    public function isSecure(): bool
    {
         return $this->isHttps() && $this->port() == 443;
    }




    /**
     * @return bool
    */
    public function isForwardedProto(): bool
    {
         return $this->get('HTTP_X_FORWARDED_PROTO') == 'https';
    }





    /**
     * Determine if request via xhr http request
     *
     * @return bool
    */
    public function isXhr(): bool
    {
        return $this->get('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }





    /**
     * @param string $method
     * @return bool
    */
    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }





    /**
     * Determine if has valid host
     *
     * @param string $host
     * @return bool
    */
    public function isValidHost(string $host): bool
    {
         return preg_match("#^". $this->host() . "$#i", $host);
    }





    /**
     * @return string
    */
    protected function authCredentials(): string
    {
          $user = $this->username();
          $pwd  = $this->password();

          $pass = $pwd ? ':' . $pwd : '';

          if ($user || $pwd) {
              $pass = '@'. $pwd;
          }

          return sprintf('%s%s', $user, $pass);
    }




    /**
     * @param array $methods
     * @return bool
    */
    public function hasResourceMethods(array $methods): bool
    {
         return in_array($this->method(), $methods);
    }
}