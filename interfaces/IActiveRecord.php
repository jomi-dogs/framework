<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/29/15
 * Time: 1:34 AM
 */

namespace framework\interfaces;


interface IActiveRecord {

    public function __construct();

    public function __get($name);

    public function __set($name,$value);

    /**
     * @param string $conditions
     *
     * @return static
     */
    public function findOne($conditions);

    /**
     * @param string $column
     * @param $value
     *
     * @return static
     */
    public function findOneBy($column,$value);

    /**
     * @param $conditions
     *
     * @return static[]
     */
    public function findAll($conditions);

    public function save();

    public function fillFromRequest();

    public function getAttributes();

    public function getAttributeNames();

    public function isRequired($attribute);

    public function getRequiredFields();

    public function getPrimaryKeys();

    public function getTable();
}