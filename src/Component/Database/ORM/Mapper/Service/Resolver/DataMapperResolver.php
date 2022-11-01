<?php
namespace Laventure\Component\Database\ORM\Mapper\Service\Resolver;

use DateTimeInterface;


/**
 *
*/
class DataMapperResolver
{

       /**
        * @var string
       */
       protected $formatDate = 'Y-m-d H:i:s';





       /**s
        * @param string $formatDate
        * @return $this
       */
       public function formatDate(string $formatDate): self
       {
            $this->formatDate = $formatDate;

            return $this;
       }




       /**
        * @param $value
        * @return mixed
       */
       public function resolveValue($value)
       {
            if ($value instanceof DateTimeInterface) {
                return $value->format($this->formatDate);
            }elseif (is_array($value)) {
                return json_encode($value, JSON_PRETTY_PRINT);
            }

            return $value;
       }
}