<?php
namespace Laventure\Component\Validation\Rules;

use Laventure\Component\Validation\Rules\Contract\RuleContract;


class RequiredValidator extends RuleContract
{


    /**
     * @inheritDoc
    */
    public function validate(): bool
    {
         return empty($this->getValue());
    }




    /**
     * @inheritDoc
     */
    public function getMessage()
    {
         return "{$this->getField()} is required.";
    }
}