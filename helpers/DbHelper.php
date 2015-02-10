<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/29/15
 * Time: 1:16 AM
 */

namespace framework\helpers;


use framework\Core;
use framework\Exception;

abstract class DbHelper {

    /**
     * @param array $values
     *
     * @return string
     */
    public static function getSets(array $values)
    {
        $sets = array();
        foreach($values as $key => $value){
            $sets[] = trim(Core::$app->db->pdo->quote($key),"'").'='.Core::$app->db->pdo->quote($value);
        }
        return join(', ',$sets);
    }

    /**
     * @param $conditions
     *
     * @return mixed
     * @throws Exception
     */
    public static function getConditions($conditions)
    {
        if(is_string($conditions))
            return ' WHERE '. $conditions;
        throw new Exception("Other functionality is not developed yet", 500);
    }

    public static function tableNameValidation($name)
    {
        if(!is_string($name))
            throw new Exception("Table name should be a string",Core::EXCEPTION_ERROR_CODE);
        return true;
    }

    public static function getKeyExpression($key,$options)
    {
        $keys = array('pk' => ' PRIMARY KEY ','fk' => ' FOREIGN KEY ');
        if(!isset($keys[$key]))
            throw new Exception("Key Type is not supported",Core::EXCEPTION_ERROR_CODE);
        $expression = $keys[$key];
        if(is_string($options))
            return $expression."($options)";
        if(!is_array($options))
            throw new Exception("Key options must be string|array. ".gettype($options)." given",Core::EXCEPTION_ERROR_CODE);
        $expression.=' ('.$options['col'].') ';
        $expression.='REFERENCES '.$options['rs']['table'].'('.$options['rs']['col'].') ';
        if(isset($options['on']) and is_array($options['on'])){
            foreach($options['on'] as $type => $action) {
                $expression.=' ON '.strtoupper($type).' '.strtoupper($action).' ';
            }
        }
        return $expression;
    }
}