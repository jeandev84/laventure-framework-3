<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\InputType;


class PasswordType extends InputType
{

    /**
     * @inheritDoc
    */
    public function getType(): string
    {
         return 'password';
    }
}