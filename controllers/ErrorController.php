<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 3:20 PM
 */

namespace framework\controllers;


use framework\Controller;
use framework\Core;
use framework\View;

class ErrorController extends Controller {

    public function actionException(\Exception $e)
    {
        $file = Core::$baseDir . '/framework/views/error/exception.php';
        return View::getInstance()->render($file,array('e' => $e));
    }

    public function actionConsoleException(\Exception $e)
    {
        $array = array();
        $array['code'] = $e->getCode();
        $array['message'] = $e->getMessage();
        $array['file'] = $e->getFile();
        $array['line'] = $e->getLine();
        $array['trace'] = $e->getTrace();
        echo json_encode($array);
        print_r($array);
//        $backtrace = debug_backtrace();
//        return View::getInstance()->render($file,array('e' => $e));
    }
}