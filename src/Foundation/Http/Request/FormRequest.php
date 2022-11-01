<?php
namespace Laventure\Foundation\Http\Request;

use Laventure\Component\Http\Request\Request;
use Laventure\Component\Validation\Contract\ValidationInterface;

/**
 * FormRequest
*/
class FormRequest extends Request
{


       /**
        * @var ValidationInterface
       */
       protected $validation;





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
             parent::__construct($queries, $request, $attributes, $cookies, $files, $server, $content);
       }



       public function validate()
       {

       }



       public function rules()
       {
           return [

           ];
       }




      public function getMessages()
      {
           return [];
      }



      public function validated()
      {

      }
}