<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/5/15
 * Time: 12:10 AM
 */

namespace framework\modules;


use app\models\Auth;
use app\models\Session;
use framework\Module;

class User extends Module{

    /**
     * @return static
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param Auth $auth
     */
    public function login(Auth $auth)
    {
        $session = new Session();
        $session->user_id = $auth->id;
        $session->login = $auth->login;
    }

    public function logout()
    {
        Session::destroy();
    }
}