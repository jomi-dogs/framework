<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/31/15
 * Time: 12:26 AM
 */

namespace jf\helpers;


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

    public static function hyphenToCamel($hyphenedStr)
    {
        $tokens = explode('-',$hyphenedStr);
        $camel = $tokens[0];
        $count = count($tokens);
        for($i = 1;$i<$count;$i++){
            $camel.=ucfirst($tokens[$i]);
        }
        return $camel;
    }
}