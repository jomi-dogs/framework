<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 5:03 PM
 */

namespace framework;


class Asset {

    public $css;
    public $js;
    protected $_allCssIncludes;
    protected $_allJsIncludes;

    public function getCSSIncludeCode($cssLink) {
        return "<link rel='stylesheet' href='$cssLink' />\n";
    }
    public function getJsIncludeCode($jsLink) {
        return "<script type='text/javascript' src='$jsLink'></script>\n";
    }

    public function getAllCssIncludes()
    {
        if(!empty($this->_allCssIncludes))
            return $this->_allCssIncludes;
        $result = '';
        foreach($this->css as $link) {
            $result.=$this->getCSSIncludeCode($link);
        }
        return $this->_allCssIncludes = $result;
    }

    public function getAllJsIncludes()
    {
        if(!empty($this->_allJsIncludes))
            return $this->_allJsIncludes;
        $result = '';
        foreach($this->js as $link) {
            $result.=$this->getJsIncludeCode($link);
        }
        return $this->_allJsIncludes = $result;
    }
}