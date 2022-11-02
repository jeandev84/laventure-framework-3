<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\InputType;

class DateType extends InputType
{

    /**
     * @inheritDoc
    */
    public function getType(): string
    {
         return 'date';
    }
}