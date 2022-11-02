<?php
namespace Laventure\Component\Helpers\Html\Form;


/**
 * FormType
*/
abstract class FormType
{

      /**
       * Element name
       *
       * @var string
      */
      protected $name;




      /**
       * Element value
       *
       * @var mixed
      */
      protected $value;





      /**
       * Element parent
       *
       * @var FormType
      */
      protected $parent;





      /**
       * Element children
       *
       * @var FormType[]
      */
      protected $children;





      /**
       * @var string
      */
      protected $label;





      /**
       * @var string
      */
      protected $attrs = [];





      /**
       * @var bool
      */
      protected $required = true;







      /**
       * Errors form type
       *
       * @var array
      */
      protected $errors = [];






      /**
       * FormType Constructor
       *
       * @param $name
       * @param array $options
      */
      public function __construct($name, array $options = [])
      {
            $this->name = $name;
            $this->parseOptions($options);
      }






      /**
       * Set form value
       *
       * @param $value
       * @return $this
      */
      public function setValue($value): self
      {
           $this->value = $value;

           return $this;
      }





      /**
       * @param FormType $parent
       * @return $this
      */
      public function setParent(FormType $parent): self
      {
           $this->parent = $parent;

           return $this;
      }





      /**
       * @return $this
      */
      public function getParent(): FormType
      {
            return $this->parent;
      }





      /**
       * @param FormType[] $children
       * @return void
      */
      public function setChildren(array $children)
      {
           foreach ($children as $element) {
                $element->setParent($this);
           }

           $this->children = array_merge($this->children, $children);
      }






      /**
       * @return FormType[]
      */
      public function getChildren(): array
      {
           return $this->children;
      }






      /**
       * @param array $errors
       * @return $this
      */
      public function setErrors(array $errors): self
      {
           $this->errors = $errors;

           return $this;
      }





      /**
       * @return array
      */
      public function getErrors(): array
      {
           return $this->errors;
      }




      /**
       * @return string
      */
      public function getName(): string
      {
           return $this->name;
      }





      /**
       * @return mixed
      */
      public function getValue()
      {
           return $this->value;
      }





      /**
       * @return string
      */
      public function getAttributes(): string
      {
            if ($this->isRequired()) {
                $this->attrs[] = 'required="required"';
            }


            return implode(" ", $this->attrs);
      }





      /**
       * @return string
      */
      public function getLabel(): string
      {
           return $this->label;
      }




      /**
       * @return bool
      */
      public function isRequired(): bool
      {
           return $this->required;
      }





      /**
       * @param array $options
       * @return void
      */
      public function parseOptions(array $options)
      {
           foreach ($options as $name => $value) {
                if (property_exists($this, $name)) {
                    $this->{$name} = $value;
                }
           }
      }




      /**
       * @return mixed
      */
      abstract public function getType();



      /**
       * @return mixed
      */
      abstract public function __toString();
}