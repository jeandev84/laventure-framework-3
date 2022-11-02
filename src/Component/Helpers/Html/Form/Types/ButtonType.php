<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\FormType;


class ButtonType extends FormType
{


    /**
     * @var bool
    */
    protected $submit;




    /**
     * @param $name
     * @param $submit
    */
    public function __construct($name, $submit = false)
    {
          parent::__construct($name, []);
          $this->submit = $submit;
    }




    /**
     * @inheritDoc
    */
    public function __toString()
    {
         return sprintf('<button type="%s" %s>%s</button>',
             $this->getType(),
             $this->getAttributes(),
             $this->getValue()
         );
    }




    /**
     * @return string
    */
    public function getType(): string
    {
        return $this->submit ? 'submit' : 'button';
    }
}