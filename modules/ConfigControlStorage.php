<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/20/15
 * Time: 1:20 AM
 */

namespace jf\modules;


use jf\base\Module;
use jf\Core;
use jf\Exception;
use jf\interfaces\IControlStorage;
use jf\interfaces\IUserEntity;

/**
 * Class ConfigControlStorage
 * @package jf\modules
 */
class ConfigControlStorage extends Module implements IControlStorage
{
    /** @var array  */
    protected $permissions = array();

    /**
     * @param IUserEntity $entity
     *
     * @return array
     */
    public function getAllPermissions(IUserEntity $entity)
    {
        if(!empty($this->permissions[$entity->getId()]))
            return $this->permissions[$entity->getId()];
        if(!empty($this->permissions[$entity->getLogin()]))
            return $this->permissions[$entity->getLogin()];
        return $this->config['default'];
    }

    /**
     * @param IUserEntity $entity
     * @param mixed       $permission
     *
     * @return bool
     * @throws Exception
     */
    public function checkPermission(IUserEntity $entity, $permission)
    {
        $path = Core::$app->router->module.'\\'.Core::$app->router->controller;
        if(isset($this->permissions[$path][$entity->getId()][$permission]))
            return $this->permissions[$path][$entity->getId()][$permission];
        if(isset($this->permissions[$path][$entity->getLogin()][$permission]))
            return $this->permissions[$path][$entity->getLogin()][$permission];
        if(isset($this->permissions[$path]['*'][$permission]))
            return $this->permissions[$path]['*'][$permission];
        if(isset($this->permissions['default'][$permission]))
            return $this->permissions['default'][$permission];
        throw new Exception("The $permission permission is not set", Core::EXCEPTION_ERROR_CODE);
    }

    /**
     * @return static
     */
    public function init()
    {
        $this->permissions = $this->config['permissions'];
    }
}