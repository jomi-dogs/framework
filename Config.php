<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 8:59 PM
 */

namespace framework;


class Config {

    /** @var  array */
    private $modules;
    /** @var  array */
    private $params;

    public function __construct(array $config)
    {
        if(!isset($config['modules']) || !isset($config['params']))
            throw new Exception("Invalid config", Core::EXCEPTION_ERROR_CODE);
        $this->modules = $config['modules'];
        $this->params = $config['params'];
    }

    public function moduleNameValidation($name)
    {
        if(!is_string($name))
            throw new Exception("Module name should be string, ". gettype($name)." given", Core::EXCEPTION_ERROR_CODE);

    }

    public function moduleConfigExists($name)
    {
        $this->moduleNameValidation($name);
        return !empty($this->modules[$name]['class']);

    }

    public function getModuleConfig($name)
    {
        if(!$this->moduleConfigExists($name))
            throw new Exception("Invalid module config given", Core::EXCEPTION_ERROR_CODE);
        return $this->modules[$name];
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getParam($name, $default = '')
    {
        $keys = explode('.',$name);
        $value = $this->params;
        foreach($keys as $key) {
            if(!isset($value[$key]))
                return $default;
            $value = $value[$key];
        }
        return $value;
    }
}