<?php
namespace Laventure\Component\Helpers\Html\Form;

use Laventure\Component\Helpers\Html\Form\Types\TextType;


/**
 * @class Form
 *
 * @package Laventure\Component\Helpers\Html\Form
 *
 * @author
*/
class Form
{


      /**
       * @var FormType[]
      */
      protected $children = [];




      /**
       * Request data
       *
       * @var array
      */
      protected $data = [];




      /**
       * Form attributes
       *
       * @var string
      */
      protected $attributes;




      /**
       * Errors validation
       *
       * @var array
      */
      protected $errors = [];





      /**
       * @var array
      */
      protected $templates = [];




      /**
       * Form constructor.
       *
       * @param array $data
      */
      public function __construct(array $data = [])
      {
             if ($data) {
                  $this->setData($data);
             }
      }




      /**
       * @param $data
       * @return void
      */
      public function setData($data)
      {
            foreach ($this->getChildren() as $children) {
                if (isset($data[$children->getName()])) {
                    $children->setValue($data[$children->getName()]);
                }
            }

            $this->data = $data;
      }




      /**
       * @param array $errors
       * @return void
      */
      public function setErrors(array $errors)
      {
          foreach ($this->getChildren() as $children) {
               if (isset($errors[$children->getName()])) {
                    $children->setErrors($errors[$children->getName()]);
               }
          }

          $this->errors = $errors;
      }





      /**
       * @param $name
       * @return array|mixed
      */
      public function getError($name)
      {
          return $this->errors[$name] ?? [];
      }





      /**
       * @return array
      */
      public function getErrors(): array
      {
           return $this->errors;
      }





      /**
       * @param $name
       * @param $default
       * @return mixed|null
      */
      public function getValue($name, $default = null)
      {
           return $this->data[$name] ?? $default;
      }





      /**
       * @return array
      */
      public function getData(): array
      {
           return $this->data;
      }





      /**
       * @param FormType $children
       * @return FormType
      */
      public function addElement(FormType $children): FormType
      {
           $name = $children->getName();

           $children->parseOptions(['value'  => $this->getValue($name)]);

           $this->children[$children->getName()] = $children;

           $this->templates[] = $children->__toString();

           return $children;
      }





      /**
       * @return array
      */
      public function getChildren(): array
      {
           return $this->children;
      }





      /**
       * @param $name
       * @param $type
       * @param array $options
       * @return $this
      */
      public function add($name, $type = null, array $options = []): self
      {
            $class   = $type ?: TextType::class;
            $element = new $class($name, $options);

            if ($element instanceof FormType) {
                $this->addElement($element);
            }

            return $this;
      }




      /**
       * @param array $attributes
       * @return void
      */
      public function open(array $attributes)
      {
           $attributes = array_merge([
               'method' => 'POST',
               'action' => ''
           ], $attributes);

           $this->attributes = array_merge($this->attributes, $attributes);
      }




      /**
       * @return string
      */
      public function close(): string
      {
           $this->templates[] = "</form>";

           return $this->createView();
      }




      /**
       * @return string
      */
      public function __toString() {
           return $this->createView();
      }





      /**
        * @return string
      */
      public function createView(): string
      {
           return join(PHP_EOL, $this->templates);
      }




      /**
       * @param $name
       * @param array $options
       * @return string
       */
      public function row($name, array $options = []): string
      {
           if (empty($this->children[$name])) {
                exit("Invalid argument row name '{$name}'");
           }

           $children = $this->children[$name];
           $children->parseOptions($options);
           return $children->__toString();
      }




      /**
       * @return void
      */
      public function resolveAttributes(array $attributes)
      {

      }
}