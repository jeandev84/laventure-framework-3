<?php
namespace Laventure\Foundation\Http\Middleware;

class SessionStartMiddleware
{

      public function __invoke()
      {
           if (! session_status()) {
                session_start();
           }
      }



      /**
        * @return array
      */
      protected function sessionOptions(): array
      {
           return [];
      }
}