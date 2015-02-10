<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/5/15
 * Time: 12:42 AM
 */

namespace framework\traits;


use framework\Core;
use framework\Exception;

trait GetterAndSetterTrait {


    function __get($name)
    {
        if(isset($this->{'_'.$name}))
            return $this->{'_'.$name};
        $callable = array($this,'get'.ucfirst($name));
        if(is_callable($callable))
            return call_user_func($callable);
        throw new Exception("Getter fail",Core::EXCEPTION_GETTER_FAIL);
    }

    function __set($name,$value)
    {
        if(isset($this->{'_'.$name}))
            return $this->{'_'.$name} = $value;
        $callable = array($this,'set'.ucfirst($name));
        if(is_callable($callable))
            return call_user_func($callable,$value);
        throw new Exception("Getter fail",Core::EXCEPTION_SETTER_FAIL);
    }
}