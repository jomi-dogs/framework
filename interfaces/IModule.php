<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/20/15
 * Time: 1:01 AM
 */

namespace jf\interfaces;


interface IModule {

    /**
     * @param array $config
     */
    public function __construct(array $config = array());

    /**
     * @param $moduleConfig
     *
     * @return static
     */
    public static function getNew(array $moduleConfig = array());
}