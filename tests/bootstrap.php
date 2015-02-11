<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 12:03 AM
 */

$_SERVER['REQUEST_URI'] = '/test/test/1';

require_once '../vendor/autoload.php';

use jf\Application;
use jf\Config;
$documentRoot = dirname(__DIR__);
$config = new Config(array_merge(
    require $documentRoot . '/config/web.php',
    require $documentRoot . '/config/test.php'
));

$app = new Application($config);