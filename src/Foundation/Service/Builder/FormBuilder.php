<?php
namespace Laventure\Foundation\Service\Builder;

use Laventure\Component\Helpers\Html\Form\Form;
use Laventure\Component\Helpers\Html\Form\FormType;
use Laventure\Component\Helpers\Html\Form\Types\TextType;
use Laventure\Component\Http\Request\Request;
use Laventure\Component\Validation\Contract\ValidatorInterface;
use Laventure\Component\Validation\Validation;


class FormBuilder
{

      /**
       * @var Form
      */
      protected $form;



      /**
       * @var Validation
      */
      protected $validation;




      /**
       * FormBuilder constructor
       *
       * @param Validation $validation
      */
      public function __construct(Validation $validation)
      {
             $this->form       = new Form();
             $this->validation = $validation;
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
                $this->form->add($element);
            }

            return $this;
       }




       /**
        * @param Request $request
        * @return void
       */
       public function handleRequest(Request $request)
       {
            // set request method _method
            $this->form->setData($request->request->all());

            // validation
       }




       /**
        * @return bool
       */
       public function isValid(): bool
       {
            return $this->isSubmit() && $this->validation->validate();
       }




       /**
        * @return array
       */
       public function getErrors(): array
       {
            $this->form->setErrors($this->validation->getErrors());

            return $this->validation->getErrors();
       }




       /**
        * @return bool
       */
       public function isSubmit(): bool
       {
            return ! empty($this->form->getData());
       }






      /**
       * @return Form
      */
      public function getForm(): Form
      {
          return $this->form;
      }
}