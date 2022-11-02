<?php
namespace Laventure\Component\Helpers\Html\Form;

/**
 * InputType
*/
abstract class InputType extends FormType
{

      /**
       * @return string
      */
      public function __toString()
      {
           return sprintf('<input type="%s" name="%s" value="%s" %s',
               $this->getType(),
               $this->getName(),
               $this->getValue(),
               $this->getAttributes()
           );
      }




      /**
       * @return string
      */
      abstract public function getType(): string;
}