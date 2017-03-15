<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 15/03/17
 * Time: 08:32
 */

namespace Insightly\Models;


abstract class AbstractModel
{

    function getOptional($key, $collection, $default = null) {
        if($collection === null) {
            return $default;
        } else if(is_array($collection)) {
            return isset($collection[$key]) ? $collection[$key] : $default;
        } else if (is_object($collection)) {
            return isset($collection->$key) ? $collection->$key : $default;
        } else {
            return $default;
        }
    }

}