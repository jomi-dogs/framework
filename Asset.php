<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/25/15
 * Time: 5:03 PM
 */

namespace jf;


class Asset {

    public $css = [];
    public $js = [];

    /**
     * @var array $depend
     * It is the array, that shows which classes this asset is dependent on
     */
    public $depend = [];
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
        if(empty($this->css) or !is_array($this->css))
            return '';
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
        if(empty($this->js) or !is_array($this->js))
            return '';
        $result = '';
        foreach($this->js as $link) {
            $result.=$this->getJsIncludeCode($link);
        }
        return $this->_allJsIncludes = $result;
    }
}