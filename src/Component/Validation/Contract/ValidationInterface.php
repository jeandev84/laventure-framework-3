<?php
namespace Laventure\Component\Validation\Contract;


/**
 * ValidationInterface
*/
interface ValidationInterface
{


      /**
        * Validate data
        *
        * @return bool
       */
       public function validate(): bool;






       /**
        * Returns validator rules
        *
        * @return ValidatorInterface[]
      */
      public function getRules(): array;






      /**
       * Returns errors messages
       *
       * @return array
      */
      public function getErrors(): array;
}