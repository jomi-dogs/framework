<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 1:22 AM
 */

namespace framework\tests\modules;


use framework\Core;
use framework\Exception;
use framework\modules\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {

    /** @var  Router */
    public $router;

    public function setUp()
    {
        $config = Core::$config->getModuleConfig('router');
        $this->router = $this->getMockBuilder(Router::class)
            ->setMethods(null)
            ->setConstructorArgs(array($config))
            ->getMock();
    }

    public function testIsModule()
    {
        $this->assertInstanceOf(Router::class,$this->router);
    }

    public function testResolveNormal()
    {
        try {
            $uri = '/controller/action/id/1';
            Core::$app->request->uri = $uri;
            $this->router->init();
            $this->assertSame($uri, $this->router->uri);
            $this->assertSame('controller', $this->router->controller);
            $this->assertSame('action', $this->router->action);
        } catch(Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testResolveWithOnlyController()
    {
        $uri = '/controller';
        Core::$app->request->uri = $uri;
        $this->router->init();
        $this->assertSame('controller',$this->router->controller);
        $this->assertSame('action',$this->router->action);
    }

    public function testResolveWithHyphenControllerAndAction()
    {
        $uri = '/controller-one/action-two';
        Core::$app->request->uri = $uri;
        $this->router->init();
        $this->assertSame('ControllerOne',$this->router->controller);
        $this->assertSame('ActionTwo',$this->router->action);
    }
}
