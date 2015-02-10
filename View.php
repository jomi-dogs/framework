<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 11:09 PM
 */

namespace framework;

/**
 * Class View
 * @package framework
 */
class View {

    /** @var  static */
    private static $_instance;
    protected $_head;
    public $layout = false;
    /** @var Asset[] */
    private $_assets = array();

    public static function getInstance()
    {
        if(!empty(static::$_instance))
            return static::$_instance;
        else
            return static::$_instance = new View();
    }

    /**
     * @param       $file
     *
     * @param array $params
     *
     * @return string
     * @throws Exception
     */
    public function render($file, array $params = array())
    {
        if(!file_exists($file))
            throw new Exception("View file $file does not exist",Core::EXCEPTION_ERROR_CODE);
        foreach($params as $paramName => $param) {
            ${$paramName} = $param;
        }
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include ($file);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     * this function prints css includes in head section
     */
    public function head()
    {
        foreach($this->_assets as $asset) {
            echo $asset->getAllCssIncludes();
        }
    }

    /**
     * return string with rendered layout
     * @param $content - it's Controller/Action result
     *
     * @return string
     * @throws Exception
     */
    public function renderLayout($content)
    {
        if(!$this->layout)
            return $content;
        $layout = Core::$baseDir.'/app/views/layouts/'.trim($this->layout,"\\/").'.php';
        if(!file_exists($layout))
            throw new Exception("Layout file $layout does not exists",Core::EXCEPTION_ERROR_CODE);
        return $this->render($layout, array('content' => $content));
    }

    /**
     * this function includes js script at the end of Body
     */
    public function endBody()
    {
        foreach($this->_assets as $asset) {
            echo $asset->getAllJsIncludes();
        }
    }

    /**
     * Register Asset instance in _assets
     * @param $assetName
     *
     * @return bool
     * @throws Exception
     */
    public function registerAsset($assetName)
    {
        if(!class_exists($assetName))
            throw new Exception("Asset $assetName does not exist", Core::EXCEPTION_ERROR_CODE);
        if(array_key_exists($assetName,$this->_assets))
            return true;
        else
            $this->_assets[$assetName] = new $assetName();
        return true;
    }
}