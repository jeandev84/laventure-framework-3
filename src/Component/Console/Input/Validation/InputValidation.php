<?php
namespace Laventure\Component\Console\Input\Validation;


use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\InputDefinition;
use Laventure\Component\Console\Input\Validators\Contract\InputValidatorInterface;
use Laventure\Component\Console\Input\Validators\InputArgumentValidator;


/**
 * @class InputValidation
*/
class InputValidation
{


     /**
      * @var InputDefinition
     */
     protected $inputs;




     /**
      * @var string[]
     */
     protected $errors = [];





     /**
      * @param InputDefinition $inputs
     */
     public function __construct(InputDefinition $inputs)
     {
          $this->inputs = $inputs;
     }






     /**
      * Validate Inputs
      *
      * @param InputInterface $input
      * @return bool
     */
     public function validate(InputInterface $input): bool
     {

     }





     public function validateArguments(array $arguments)
     {

     }



     /**
      * @return string[]
     */
     public function getErrors(): array
     {
          return $this->errors;
     }
}