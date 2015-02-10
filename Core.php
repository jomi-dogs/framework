<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 8:53 PM
 */
namespace framework;

define('BASE_DIR',dirname(__DIR__));
define('FRAMEWORK_DIR',__DIR__);
/**
 * Class Core
 * @package framework
 */
class Core {
    const EXCEPTION_ERROR_CODE = 500;
    const EXCEPTION_NOT_ERROR_CODE = 1024;
    const EXCEPTION_GETTER_FAIL = 1025;
    const EXCEPTION_SETTER_FAIL = 1026;

    /** @var  Application */
    public static $app;
    /** @var  Config */
    public static $config;

    public static $baseDir = BASE_DIR;
    public static $frameworkDir = FRAMEWORK_DIR;
    /**
     * @param $name
     *
     * @return bool
     */
    public static function moduleExists($name)
    {
        return self::$config->moduleConfigExists($name);
    }

    /**
     * @param string $name
     *
     * @return Module
     */
    public static function getModule($name)
    {
        return Module::getNew(static::$config->getModuleConfig($name));
    }


}