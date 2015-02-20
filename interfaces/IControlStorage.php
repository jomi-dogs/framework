<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/20/15
 * Time: 12:48 AM
 */

namespace jf\interfaces;


interface IControlStorage extends IModule{

    /**
     * @param IUserEntity $entity
     *
     * @return array
     */
    public function getAllPermissions(IUserEntity $entity);

    /**
     * @param IUserEntity $entity
     * @param mixed       $permission
     *
     * @return bool
     */
    public function checkPermission(IUserEntity $entity, $permission);
}