<?php
namespace Laventure\Component\Validation\Rules\Contract;

use Laventure\Component\Validation\Contract\ValidatorInterface;


abstract class RuleContract implements ValidatorInterface
{

      /**
       * @var string
      */
      protected $field;




      /**
       * @var string
      */
      protected $value;





      /**
       * @param $field
       * @param $value
      */
      public function __construct($field, $value)
      {
           $this->field = $field;
           $this->value = $value;
      }






       /**
        * @inheritdoc
       */
       public function getValue()
       {
           return $this->value;
       }




       /**
        * @inheritdoc
       */
       public function getField()
       {
           return $this->field;
       }
}