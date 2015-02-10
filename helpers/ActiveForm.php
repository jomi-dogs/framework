<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 5:47 PM
 */

namespace framework\helpers;


class ActiveForm {

    public static function getArguments(array $arguments)
    {
        $result = '';
        foreach($arguments as $name => $value) {
            if(empty($value))
                continue;
            $result.=' '.$name.'="'.$value.'" ';
        }
        return $result;
    }
    public static function start($action, $method, $name = '', $class = '', $id = '')
    {
        $arguments = static::getArguments(array(
            'action' => $action,
            'method' => $method,
            'name' => $name,
            'class' => $class,
            'id' => $id
        ));

        return "<form $arguments>";
    }

    public static function end()
    {
        return '</form>';
    }

    public static function input($type,$name,$defaultValue = '',$class = '', $id = '')
    {
        $arguments = static::getArguments(array(
            'type' => $type,
            'name' => $name,
            'value' => $defaultValue,
            'class' => $class,
            'id' => $id
        ));
        return "<input $arguments/>";
    }

    public static function textArea($name,$defaultText, $class = '', $id = '')
    {
        if(!empty($class))
            $class = "class='$class'";
        if(!empty($id))
            $id = "id='$id'";
        return "<textarea name='$name' $class $id>$defaultText</textarea>";
    }

    public static function button($type,$name,$text,$class = '', $id = '')
    {
        if(!empty($class))
            $class = "class='$class'";
        if(!empty($id))
            $id = "id='$id'";

        return "<button type='$type' name='$name' $class $id>$text</button>";
    }

}