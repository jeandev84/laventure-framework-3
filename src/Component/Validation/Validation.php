<?php
namespace Laventure\Component\Validation;


use Laventure\Component\Validation\Contract\ValidationInterface;
use Laventure\Component\Validation\Contract\ValidatorInterface;



/**
 * Validation
*/
class Validation implements ValidationInterface
{



    /**
     * Local language
     *
     * @var string
    */
    protected $lang;





    /**
     * Return Lang directory
     *
     * @var string
    */
    protected $langPath;






    /**
     * Storage validation rules
     *
     * @var ValidatorInterface[]
    */
    protected $rules = [];




    /**
     * Storage error messages
     *
     * @var string[]
    */
    protected $errors = [];





    /**
     * Optional params
     *
     * @var array
    */
    protected $options = [];





    /**
     * Validation constructor.
     *
     * @param string $lang
     * @param array $options
    */
    public function __construct(string $lang = 'en_EN', array $options = [])
    {
         $this->lang     = $lang;
         $this->options  = $options;
    }





    /**
     * @param $path
     * @return void
    */
    public function langPath($path)
    {
         $this->langPath = $path;
    }






    /**
     * Add rule
     *
     * @param ValidatorInterface $rule
     * @return $this
    */
    public function addRule(ValidatorInterface $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function validate(): bool
    {
        foreach ($this->rules as $rule) {

            $valid = $rule->validate();

            if (! $valid) {
                $this->addError($rule);
                return false;
            }
        }

        return true;
    }








    /**
     * @inheritDoc
    */
    public function getRules(): array
    {
         return $this->rules;
    }




    /**
     * @inheritDoc
    */
    public function getErrors(): array
    {
         return $this->errors;
    }







    /**
     * Add error
     * @param ValidatorInterface $validator
     * @return $this
    */
    public function addError(ValidatorInterface $validator): self
    {
        $this->errors[$validator->getField()][] = $this->translate($validator->getMessage());

        return $this;
    }






    /**
     * @param string $message
     * @return string
    */
    protected function translate(string $message): string
    {
         if (is_file($path = $this->languagePath())) {
              $params = require $path;
              return str_replace(array_keys($params), array_values($params), $message);
         }

         return $message;
    }






    /**
     * @return string
    */
    private function languagePath(): string
    {
         $lang = explode('_', $this->lang, 2);
         $lang = array_shift($lang);

         return realpath(($this->langPath ?: __DIR__)."/{$lang}/params.php");
    }
}
