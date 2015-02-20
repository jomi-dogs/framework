<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 8:59 PM
 */

namespace jf;

/**
 * Class Config
 * @package jf
 */
class Config {

    /** @var  array  */
    protected $moduleNamespaces = [];
    private $controllerNamespace;

    /** @var  array */
    private $modules;
    /** @var  array */
    private $params;

    public function __construct(array $config)
    {
        if(!isset($config['modules']) || !isset($config['params']))
            throw new Exception("Invalid config", Core::EXCEPTION_ERROR_CODE);
        foreach($config as $property => $value )
            $this->{$property} = $value;
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

    public function getControllerNamespace()
    {
        if(!empty($this->controllerNamespace))
            return $this->controllerNamespace;
        return '\\app\\controllers\\';
    }

    /**
     * @param $moduleName
     *
     * @return string
     */
    public function getModuleNamespace($moduleName)
    {
        if(!empty($this->modules[$moduleName]['controllerNamespace']))
            return $this->modules[$moduleName]['controllerNamespace'];
        else return '';
    }
    public function getModulesControllerNamespaces()
    {
        if(!empty($this->moduleNamespaces))
            return $this->moduleNamespaces;
        $namespaces = [];
        foreach ($this->modules as $module) {
            if(!empty($module['controllerNamespace'])){
                $namespaces[] = $module['controllerNamespace'];
            }
        }
        return $this->moduleNamespaces = $namespaces;
    }

    public function getModules()
    {
        return $this->modules;
    }

}