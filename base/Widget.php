<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/18/15
 * Time: 12:49 AM
 */

namespace jf\base;


use jf\Core;
use jf\Module;
use jf\View;

class Widget extends Module
{

    public $view = 'widget';
    public $path = 'widgets';

    /**
     * @param array $config
     *
     * @return mixed
     */
    public static function widget(array $config) {
        return (new static($config))->exec();
    }

    /**
     * @return static
     */
    public function init()
    {
        if(!empty($this->_config['isBootstrap']))
            $this->view.='_bootstrap';
    }

    /**
     * @return string
     * @throws \jf\Exception
     */
    public function exec()
    {
        return View::getInstance()->render(Core::$jfDir.'/views/'.$this->path.'/'.$this->view.'.php',$this->_config);
    }
}