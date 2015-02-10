<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/31/15
 * Time: 12:26 AM
 */

namespace framework\helpers;


abstract class UriHelper {

    public static function getClassNameFromUri($uri)
    {
        $name = '';
        $parts = explode('-',$uri);
        foreach($parts as $part) {
            $name.=ucfirst($part);
        }
        return $name;
    }
}