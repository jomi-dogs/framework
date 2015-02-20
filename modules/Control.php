<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/20/15
 * Time: 12:35 AM
 */

namespace jf\modules;


use jf\Core;
use jf\interfaces\IControlStorage;
use jf\interfaces\IUserEntity;
use jf\base\Module;

class Control extends Module {

    /** @var  IControlStorage */
    protected $controlStorage;

    /**
     * @return static
     */
    public function init()
    {
        $this->controlStorage = Core::$app->controlStorage;
    }

    /**
     * @param IUserEntity $entity
     *
     * @param mixed       $permission
     *
     * @return bool
     */
    public function allowed(IUserEntity $entity, $permission)
    {
        return $this->controlStorage->checkPermission($entity,$permission);
    }

    /**
     * @param $permission
     *
     * @return bool
     */
    public function IAllowed($permission)
    {
        return $this->controlStorage->checkPermission(
            Core::$app->user,
            $permission
        );
    }

    public function getPermissions(IUserEntity $entity)
    {
        return $this->controlStorage->getAllPermissions($entity);
    }

    /**
     * @return array
     */
    public function getMyPermissions()
    {
        return $this->controlStorage->getAllPermissions(
            Core::$app->user
        );
    }
}