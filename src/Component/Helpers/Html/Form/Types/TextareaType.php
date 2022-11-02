<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\FormType;


class TextareaType extends FormType
{

    /**
     * @inheritDoc
    */
    public function __toString()
    {
         return sprintf('<textarea name="%s" %s>%s</textarea>',
                $this->getName(),
                $this->getAttributes(),
                $this->getValue()
         );
    }
}