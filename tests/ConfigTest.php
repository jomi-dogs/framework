<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 12:58 AM
 */

namespace framework\tests;


use framework\Config;
use framework\Core;
use framework\modules\Router;

class ConfigTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        try{
            new Config(array());
            $this->fail("There wasn't the Exception");
        } catch (\Exception $e) {
            $this->assertSame("Invalid config",$e->getMessage());
        }
        try{
            $config = new Config(array('params'=>array(),'modules'=>array()));
            $this->assertInstanceOf(Config::class,$config);
        } catch (\Exception $e) {
            $this->fail("There was the Exception:".$e->getMessage());
        }
    }

    public function testModuleNameValidation()
    {
        try{
            Core::$config->moduleNameValidation('router');
        } catch(\Exception $e)  {
            $this->fail("There were Exception:".$e->getMessage());
        }
        try{
            Core::$config->moduleNameValidation(array());
            $this->fail("There were no Exceptions");
        } catch(\Exception $e) {

        }
    }

    public function testGetModuleConfig()
    {
        try{
            $config = Core::$config->getModuleConfig('router');
            $this->assertSame(Router::class,$config['class']);
        } catch(\Exception $e) {
            $this->fail("There was the Exception:".$e->getMessage());
        }
    }

    public function testGetParam()
    {
        try{
            $config = Core::$config;
            $param = $config->getParam('test','123');
            $this->assertSame('123test',$param);
            $param = $config->getParam('123','2345');
            $this->assertSame('2345', $param);
            $param = $config->getParam('test2.test3.test4','123');
            $this->assertSame('testParamString',$param);
        } catch(\Exception $e) {
            $this->fail("There was the Exception:".$e->getMessage());
        }
    }
}
