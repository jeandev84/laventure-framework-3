<?php
namespace Laventure\Component\Http\Bag;


class HeaderBag extends ParameterBag
{

    /**
     * @return bool
    */
    public function hasHeaders(): bool
    {
        return ! empty($this->params);
    }




    /**
     * @return void
    */
    public function removeHeaders()
    {
         $this->params = [];
    }




    /**
     * @param $key
     * @return void
    */
    public function removeHeader($key)
    {
         unset($this->params[$key]);
    }
}