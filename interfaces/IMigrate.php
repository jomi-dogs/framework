<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/31/15
 * Time: 5:21 PM
 */

namespace framework\interfaces;


interface IMigrate extends IController{

    function actionDo($name);
    function actionUp($count = 0);
    function actionDown($count = 0);

}