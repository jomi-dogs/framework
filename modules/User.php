<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/5/15
 * Time: 12:10 AM
 */

namespace jf\modules;

use jf\Core;
use jf\interfaces\IUserEntity;
use jf\Module;
use jf\traits\GetterAndSetterTrait;

class User extends Module
{
    use GetterAndSetterTrait;

    public $_guest = true;
    /**
     * @return static
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param IUserEntity $auth
     */
    public function login(IUserEntity $auth)
    {
        Core::$app->session->user_id = $auth->getId();
        Core::$app->session->login = $auth->getLogin();
        $this->_guest = false;
    }

    public function logout()
    {
        Session::destroy();
        $this->_guest = true;
    }

    public function isGuest()
    {
        return $this->_guest;
    }
}