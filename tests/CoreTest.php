<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 12:28 AM
 */

namespace jf\tests;


use jf\Core;
use jf\Exception;

class CoreTest extends \PHPUnit_Framework_TestCase {

    public function testModuleExists()
    {
        try{
            $this->assertTrue(Core::moduleExists('router'),"Module does Not exists");
            $this->assertFalse(Core::moduleExists('123'),"Module exists");
        } catch(Exception $e) {
            $this->fail("There was the Exception:".$e->getMessage());
        }
    }

    /**
     * @depends testModuleExists
     */
    public function testGetModule()
    {
        try{
            $router = Core::getModule('router');
            $this->assertInstanceOf('jf\modules\Router',$router,"Fail instance check.");
        } catch (Exception $e) {
            $this->fail("There were the Exception:".$e->getMessage());
        }
        $this->assertTrue(true);
    }
}
