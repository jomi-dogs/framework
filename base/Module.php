<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/24/15
 * Time: 1:40 PM
 */

namespace jf\base;


use jf\interfaces\IModule;
use jf\traits\GetterAndSetterTrait;

/**
 * Class Module
 * @package jf\base
 * @property array config
 */
abstract class Module implements IModule
{
    use GetterAndSetterTrait;

    /** @var array  */
    protected $_config;
    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->_config = $config;
        $this->init();
    }

    /**
     * @return static
     */
    public abstract function init();

    /**
     * @param $moduleConfig
     *
     * @return static
     */
    public static function getNew(array $moduleConfig = array())
    {
        return new $moduleConfig['class']($moduleConfig);
    }
}