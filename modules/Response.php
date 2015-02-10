<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/24/15
 * Time: 4:07 PM
 */

namespace framework\modules;

use framework\Module;
use framework\View;

/**
 * Class Response
 * @package framework\modules
 */
class Response extends Module{

    /**
     * @return static
     */
    public function init()
    {

    }

    /**
     * @param $result
     *
     * @return bool
     */
    public function perform($result)
    {
        switch(gettype($result)) {
            case "boolean":
                $result = $result?'true':'false';
                break;
            case "integer":
                break;
            case "double":
                break;
            case "float":
                break;
            case "string":
                break;
            case "array":
                $result = json_encode($result);
                break;
            case "object":
                $result = serialize($result);
                break;
            case "resource":
                $result = serialize($result);
                break;
            case "NULL":
                $result = "NULL";
                break;
            case "unknown type":
                return false;
                break;
            default:
                break;
        }
        echo View::getInstance()->renderLayout($result);
        return true;
    }
}