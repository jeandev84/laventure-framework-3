<?php
namespace Laventure\Component\Helpers\Html\Form\Types;


class SubmitType extends ButtonType
{
     /**
      * @return string
     */
     public function getType(): string
     {
         return 'submit';
     }
}