<?php
namespace jf\widgets;

use jf\base\Widget;
use jf\Core;
use jf\Exception;

/**
 * Class Nav
 * @package jf\widgets
 * @author <lugamax@gmail.com> MaCSeeM
 */
class Nav extends Widget
{
    public $view = 'nav';

    public function exec() {
        if(empty($this->_config['items']) or !is_array($this->_config['items']))
            throw new Exception("Nav items are empty",Core::EXCEPTION_ERROR_CODE);
        foreach($this->_config['items'] as &$item) {
            $item = $this->prepare($item);
        }
        return parent::exec();
    }

    /**
     * @param $item
     *
     * return string
     */
    protected function prepare($item)
    {
        if(is_string($item))
            return $item;
    }
}