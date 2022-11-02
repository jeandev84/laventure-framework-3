<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\InputType;

class EmailType extends InputType
{

    /**
     * @inheritDoc
    */
    public function getType(): string
    {
         return 'email';
    }
}