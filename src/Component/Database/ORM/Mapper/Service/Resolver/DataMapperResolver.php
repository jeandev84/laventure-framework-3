<?php
namespace Laventure\Component\Database\ORM\Mapper\Service\Resolver;

use DateTimeInterface;


/**
 *
*/
class DataMapperResolver
{
       /**
        * @param $value
        * @return mixed
       */
       public function resolveValue($value)
       {
            if ($value instanceof DateTimeInterface) {
                return $value->format("Y-m-d H:i:s");
            }elseif (is_array($value)) {
                return json_encode($value, JSON_PRETTY_PRINT);
            } elseif (is_bool($value)) {
                 return $value ? 1 : 0;
            }

            return $value;
       }
}