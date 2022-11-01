<?php
namespace Laventure\Component\Validation\Rules;


use Laventure\Component\Validation\Rules\Contract\RuleContract;


/**
 * @EmailValidator
 */
class EmailValidator extends RuleContract
{



    /**
     * @return bool
    */
    public function validate(): bool
    {
        return filter_var($this->getValue(), FILTER_VALIDATE_EMAIL);
    }





    /**
     * @return string
    */
    public function getMessage(): string
    {
        return "{$this->getField()} is not valid email.";
    }
}