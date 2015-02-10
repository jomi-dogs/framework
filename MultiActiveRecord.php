<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/29/15
 * Time: 1:38 AM
 */

namespace framework;


use framework\interfaces\IActiveRecord;

class MultiActiveRecord implements IActiveRecord{


    public function __construct()
    {
        // TODO: Implement __construct() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    public function findOne($conditions)
    {
        return $this;
        // TODO: Implement findOne() method.
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy($column, $value)
    {
        return $this;
        // TODO: Implement findBy() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function fillFromRequest()
    {
        // TODO: Implement fillFromRequest() method.
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
    }

    public function getAttributeNames()
    {
        // TODO: Implement getAttributeNames() method.
    }

    public function isRequired($attribute)
    {
        // TODO: Implement isRequired() method.
    }

    public function getRequiredFields()
    {
        // TODO: Implement getRequiredFields() method.
    }

    public function getPrimaryKeys()
    {
        // TODO: Implement getPrimaryKeys() method.
    }

    public function getTable()
    {
        // TODO: Implement getTable() method.
    }

    /**
     * @param $conditions
     *
     * @return static[]
     */
    public function findAll($conditions)
    {
        return array();
        // TODO: Implement findAll() method.
    }
}