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

class Request extends Module{

    /** @var   */
    public $uri;
    public $get = array();
    public $post = array();
    /**
     * @return static
     */
    public function init()
    {
        switch(Core::$app->type) {
            case 'web':
                $this->uri = $this->getUri();
                if(!empty($_GET))
                    $this->get = $_GET;
                if(!empty($_POST))
                    $this->post = $_POST;
                unset($_GET);
                unset($_POST);
                break;
            case 'console':
                if(isset($argv[1]))
                    $this->uri = $argv[1];
                break;
        }

    }

    /**
     * @return string
     */
    public function getUri()
    {
        if(isset($_SERVER['REQUEST_URI']))
            return $_SERVER['REQUEST_URI'];
        return '';
    }

    /**
     * @param \ReflectionParameter[] $actionArgs
     *
     * @return array
     * @throws Exception
     */
    public function getActionParams($actionArgs)
    {
        $args = array();
        foreach($actionArgs as $param)
        {
            $argName = $param->getName();
            if(!empty($this->get[$argName]))
                $args[] = $this->get[$argName];
            elseif(!empty($this->post[$argName]))
                $args[] = $this->post[$argName];
            elseif($param->isDefaultValueAvailable())
                $args[] = $param->getDefaultValue();
            else
                throw new Exception("Can't get action param:".$argName,Core::EXCEPTION_ERROR_CODE);
        }
        return $args;
    }
}