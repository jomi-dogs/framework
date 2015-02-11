<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/12/15
 * Time: 12:47 AM
 */

namespace jf\modules;


use jf\Core;
use jf\Exception;
use jf\Module;
use jf\traits\GetterAndSetterTrait;

class Session extends Module{

    use GetterAndSetterTrait{
        __get as getter;
        __set as setter;
    }

    /**
     * @return static
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    public function start(){
        session_start();
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];
        try {
            return $this->getter($name);
        } catch(Exception $e) {}
        throw new Exception("No $name parameter in session", Core::EXCEPTION_ERROR_CODE);
    }

    public function __set($name,$value)
    {
        try {
            return $this->setter($name,$value);
        } catch(Exception $e) {
            if (!$e->getCode() == Core::EXCEPTION_SETTER_FAIL)
                throw $e;
        }
        return $_SESSION[$name] = $value;
    }
}