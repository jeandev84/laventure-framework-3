<?php
namespace Laventure\Component\Validation\Contract;

/**
 * ValidatorInterface
*/
interface ValidatorInterface
{

    /**
     * Validator name
     *
     * @return mixed
    */
    public function getName();





    /**
     * Returns field name
     *
     * @return mixed
    */
    public function getField();






    /**
     * Returns parameter value
     *
     * @return mixed
    */
    public function getValue();





    /**
     * Determine if the given value is validated
     *
     * @return bool
    */
    public function validate(): bool;




    /**
     * Return validator message
     *
     * @return mixed
    */
    public function getMessage();
}