<?php
namespace Laventure\Component\Helpers\Html\Form\Types;

use Laventure\Component\Helpers\Html\Form\InputType;

class TextType extends InputType
{

    public function getType(): string
    {
         return 'text';
    }
}