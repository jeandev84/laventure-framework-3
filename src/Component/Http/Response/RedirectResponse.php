<?php
namespace Laventure\Component\Http\Response;

/**
 * RedirectResponse
*/
class RedirectResponse extends Response
{

      /**
       * @var string
      */
      protected $path;




      /**
       * @param string $path
       * @param int $statusCode
       * @param array $headers
      */
      public function __construct(string $path, int $statusCode = 301, array $headers = [])
      {
            parent::__construct(null, $statusCode, $headers);

            $this->path = $path;
      }




      /**
        * @param $path
        * @return void
      */
      public function path($path)
      {
          $this->path = $path;
      }




      /**
       * @return void
      */
      public function send()
      {
           http_response_code($this->statusCode);
           header(sprintf('Location: %s', $this->path));
           $this->sendRedirectBody();
      }




      /**
       * @return void
      */
      protected function sendRedirectBody()
      {
          echo sprintf("
             <!DOCTYPE html>
             <html>
                <head>
                   <meta charset='UTF-8'>
                   <title>Redirect %s</title>
                </head>
                <body>
                    <h1>Redirect temporary to page %s with status %s</h1>
                </body>
             </html>
             ", $this->statusCode, $this->path, $this->statusCode);
      }
}