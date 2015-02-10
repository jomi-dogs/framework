<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/24/15
 * Time: 12:47 AM
 */

namespace framework\modules;


use framework\Core;
use framework\Exception;
use framework\Module;

class ConsoleRequest extends Request{

    /** @var string  */
    public $uri;
    public $args = array();
    /**
     * @return static
     */
    public function init()
    {
        $this->args = $this->_config['argv'];
        $this->uri = $this->getUri();

    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUri()
    {
        if(isset($this->args[1]))
            return $this->args[1];
        throw new Exception("Can't get Uri");
    }

    /**
     * @param \ReflectionParameter[] $actionArgs
     *
     * @return array
     * @throws Exception
     */
    public function getActionParams($actionArgs)
    {
        $actualCount = count($this->args)-2;
        $expectedCount = count($actionArgs);
        if($expectedCount != $actualCount )
            throw new Exception("Expected $expectedCount arguments, $actualCount passed", Core::EXCEPTION_ERROR_CODE);
        $params = array();
        foreach(array_slice($this->args,2) as $param)
        {
            $paramExplode = explode('=',$param,2);
            $params[$paramExplode[0]] = $paramExplode[1];
        }
        $result = array();
        foreach($actionArgs as $actionArg){
            if(!isset($params[$actionArg->getName()]) && !$actionArg->isDefaultValueAvailable()) {
                throw new Exception("Param ".$actionArg->getName()." can not be empty");
            }
            if(!isset($params[$actionArg->getName()])){
                $result[] = $actionArg->getDefaultValue();
            } else {
                $result[] = $params[$actionArg->getName()];
            }
        }
        return $result;
    }
}