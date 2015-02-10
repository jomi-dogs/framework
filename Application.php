<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 8:56 PM
 */

namespace framework;
use framework\controllers\ErrorController;
use framework\modules\Db;
use framework\modules\Request;
use framework\modules\Response;
use framework\modules\Router;
use framework\modules\User;

/**
 * Class Application
 * @package framework
 * @property array $params
 * @property Router $router
 * @property Response $response
 * @property Request $request
 * @property Db $db
 * @property User $user
 */
class Application {

    /** @var  array */
    public $params;
    /** @var  Config */
    protected $config;

    public $type = 'web';

    public function __construct(Config $config)
    {
        Core::$app = $this;
        $this->init($config);
    }

    public function __get($name)
    {
        if(!empty($this->{'_'.$name}))
            return $this->{'_'.$name};
        if(method_exists($this,'get'.ucfirst($name)))
            return $this->{'_'.$name} = $this->{'get'.ucfirst($name)};
        if(Core::moduleExists($name))
            return $this->{'_'.$name} = Core::getModule($name);
        throw new Exception("Can't get method:".$name, Core::EXCEPTION_ERROR_CODE);
    }

    protected function init(Config $config)
    {
        Core::$config = $config;
        $this->params = $config->getParams();
        $this->config = $config;
    }

    public function run()
    {
        session_start();
        try{
            $result = $this->handleRequest();
            $this->response->perform($result);
        } catch(Exception $e) {
            $this->performError($e);
        }
    }

    protected function performError(\Exception $e)
    {
        $controller = new ErrorController();
        $this->response->perform($controller->actionException($e));
    }

    public function handleRequest()
    {
        $controller = $this->getController($this->router->controller);
        $controller->beforeAction();
        return $controller->runAction($this->router->action);
    }

    protected function getControllerNamespaces()
    {
        return array(
            '\\app\\controllers\\',
            '\\framework\\controllers\\'
        );
    }

    protected function getControllerSuffixes()
    {
        return array(
            '',
            'Controller'
        );
    }

    /**
     * @param $controller
     *
     * @return Controller
     * @throws Exception
     */
    protected function getController($controller)
    {
        foreach($this->getControllerNamespaces() as $namespace) {
            foreach($this->getControllerSuffixes() as $suffix){
                $name = $namespace . ucfirst($controller) . $suffix;
                if(class_exists($name))
                    return new $name();
            }
        }
        throw new Exception("Controller $controller could not be found", Core::EXCEPTION_ERROR_CODE);
    }


}