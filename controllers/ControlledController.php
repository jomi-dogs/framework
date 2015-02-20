<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/20/15
 * Time: 1:53 AM
 */

namespace jf\controllers;


use jf\Controller;
use jf\Core;
use jf\Exception;
use jf\modules\Control;
use jf\traits\GetterAndSetterTrait;

/**
 * Class ControlledController
 * @package jf\controllers
 * @property Control $control
 */
abstract class ControlledController extends Controller
{
    use GetterAndSetterTrait;

    /** @var  Control */
    protected $_control;

    /**
     * @return Control
     */
    protected function getControl()
    {
        $this->_control = Core::$app->control;
        return $this->_control;
    }

    public function beforeAction($action)
    {
        if (!$this->control->IAllowed(
            $this->getPermissionByAction($action))
        )
            throw new Exception("The $action action is not allowed for this user");
        parent::beforeAction($action);
    }

    /**
     * This function is for customise
     *
     * e.g. You have 2 actions
     * view and list
     * and you want that permission "read"
     * would be apply for this actions
     * so, for solving this problem
     * you need
     * * implement this function in child class
     * {code example implementation}
     * $permissions = [ 'view' => 'read', 'list' => 'read', '*' => edit ]
     * if(isset($permissions[$action])) return $permissions[$action];
     * return $permissions['*'];
     * {/code}
     *
     * @param $action
     *
     * @return string
     */
    public function getPermissionByAction($action)
    {
        return $action;
    }
}