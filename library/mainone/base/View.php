<?php

/**
 *
 * 视图类, 注:本类仅用于php格式的视图文件
 * 
 */

if (!defined('IN_MAINONE')) {
    exit();
}

class View extends Base {

    /**
     * 单例模式实现化对象
     *
     * @var object
     */
    protected static $_instance = null;


    /**
     * 视图变量数组
     *
     * @var array
     */
    protected $_options;

    /**
     * 视图缓存文件
     *
     * @var string
     */
    protected $cacheFile;

    /**
     * 视图缓存重写开关
     *
     * @var boolean
     */
    protected $cacheStatus;


    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct() {

        //定义变量
        $this->_options     = array();
        $this->cacheStatus = false;

        return true;
    }



    /**
     * 分析视图文件
     *
     * @access publice
     * @param string $fileName 视图文件名，注:名称中不带.php后缀。
     * @return void
     *
     * @example
     * 法一：
     * include $this->getViewFile('list');
     *
     * 法二：
     * include $this->getViewFile();    //即:当前controller视图目录下,当前action所对应的视图名称
     * 如当前action为demo，则相当于$this->getViewFile('demo');
     *
     * 法三：
     * include $this->getViewFile('xx_controller/xx_action');
     */
    public function getViewFile($fileName = null) {

        //参数分析
        if (is_null($fileName)) {
            $fileName = app::getControllerName() . '/' . app::getActionName();
        } else {
            $fileName = (strpos($fileName, '/') !== false) ? $fileName : app::getControllerName() . '/' . $fileName;
        }

        //分析视图文件所在的目录,是否视图使用了主题
        $viewFile  = (!empty($this->theme)) ? DIR_THEME . $this->theme . '/' . $fileName : DIR_VIEW . app::$module . '/' . $fileName;
        
 
        $viewFile .= '.php';

//        echo $viewFile;
        //分析视图文件是否存在
        if (!is_file($viewFile)) {
            Controller::halt('The view file:' . $viewFile . ' is not exists!');
        }
        return $viewFile;
    }


    /**
     * 分析视图缓存文件名
     *
     * @access protected
     * @param string $cacheId 缓存ID
     * @return string
     */
    protected function parseCacheFile($cacheId) {

        return DIR_CACHE . 'html/' . app::getControllerName() . '/' . md5($cacheId) . '.action.html';
    }

    /**
     * 分析视图缓存文件是否需要重新创建
     *
     * @access public
     * @param string $cacheId 缓存ID
     * @param integer $lifetime 缓存文件生存周期, 默认为一年
     * @return boolean
     */
    public function cache($cacheId = null, $lifetime = null) {

        //参数分析
        if (is_null($cacheId)) {
            $cacheId = app::getActionName();
        }
        if (is_null($lifetime)) {
            $lifetime = 31536000;
        }

        //获取缓存文件
        $cacheFile = $this->parseCacheFile($cacheId);
        if (is_file($cacheFile) && (filemtime($cacheFile) + $lifetime >= time())) {
            include $cacheFile;
            exit();
        }

        $this->cacheStatus = true;
        $this->cacheFile   = $cacheFile;

        return true;
    }


    /**
     * 创建缓存文件
     *
     * @access protected
     * @param string $cacheFile 缓存文件名
     * @param string $content 缓存文件内容
     * @return boolean
     */
    protected function createCacheFile($cacheFile, $content = null) {

        //参数分析
        if (!$cacheFile) {
            return false;
        }
        if (is_null($content)) {
            $content = '';
        }

        //分析缓存目录
        $cacheDir = dirname($cacheFile);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        } else if (!is_writable($cacheDir)) {
            chmod($cacheDir, 0777);
        }

        return file_put_contents($cacheFile, $content, LOCK_EX);
    }

    /**
     * 视图变量赋值操作
     *
     * @access public
     * @param mixted $keys 视图变量名
     * @param string $value 视图变量值
     * @return mixted
     */
    public function assign($keys, $value = null) {

        //参数分析
        if (!$keys) {
            return false;
        }

        //当$keys为数组时
        if (!is_array($keys)) {
            $this->_options[$keys] = $value;
        } else {
            foreach ($keys as $handle=>$lines) {
                $this->_options[$handle] = $lines;
            }
        }

        return true;
    }

    /**
     * 显示当前页面的视图内容
     * 
     * @access public
     * @param string $fileName 视图名称
     * @return void
     */
    public function display($fileName = null) {

        //分析视图文件路径
        $viewFile = $this->getViewFile($fileName);

        //模板变量赋值
        if (!empty($this->_options)) {
            extract($this->_options, EXTR_PREFIX_SAME, 'data');
            //清空不必要的内存占用
            $this->_options = array();
        }

        //获取当前视图($fileName)的内容
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        //分析,加载,显示layout视图内容
        $layoutFile = (!empty($this->theme)) ? DIR_THEME . $this->theme . '/layout/' . $this->layout . '.php' : DIR_VIEW . 'layout/' . $this->layout . '.php';
        
        echo $layoutFile;

        //分析layout文件是否存在.
        if (is_file($layoutFile)) {
            ob_start();
            include $layoutFile;
            $content = ob_get_clean();
        }

        //显示视图文件内容
        echo $content;

        //当缓存重写开关开启时,创建缓存文件
        if ($this->cacheStatus == true) {
            $this->createCacheFile($this->cacheFile, $content);
        }
    }

    /**
     * 加载并显示视图片段文件内容
     *
     * 相当于include 代码片段，当$return为:true时返回代码代码片段内容,反之则显示代码片段内容
     * @access public
     * @param string  $fileName 视图片段文件名称
     * @param array   $_data     视图模板变量，注：数组型
     * @param boolean $return    视图内容是否为返回，当为true时为返回，为false时则为显示. 默认为:false
     * @return mixed
     */
    public function render($fileName, $_data = array(), $return = false) {

        //参数分析
        if (!$fileName) {
            return false;
        }

        //分析视图文件的路径
        $viewFile = $this->getViewFile($fileName);

        //模板变量赋值
        if (!empty($_data) && is_array($_data)) {
            extract($_data, EXTR_PREFIX_SAME, 'data');
            unset($_data);
        }

        //获取$fileName所对应的视图片段内容
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if (!$return) {
            echo $content;
        } else {
            return $content;
        }
    }

    /**
     * URL组装
     *
     * @access public
     * @param string    $route         controller与action
     * @param array     $params         URL路由其它字段
     * @param boolean   $routingMode  网址是否启用路由模式
     * @return string   URL
     */
    public static function createUrl($route, $params = null, $routingMode = true) {

        return Controller::createUrl($route, $params, $routingMode);
    }

    /**
     * 获取当前URL
     *
     * @access public
     * @return string URL
     */
    public static function getBaseUrl() {

        return Controller::getBaseUrl();
    }

    /**
     * 获取当前运行的Action的URL
     *
     * @access public
     * @return string    URL
     */
    public static function getSelfUrl() {

        return Controller::getSelfUrl();
    }

    /**
     * 获取当前module Controller内的某Action的URL
     * 
     * 该网址仅由项目入口文件和控制器组成
     * 
     * @access public
     * @param string $actionName 所要获取URL的action的名称
     * @return string    URL
     */
    public static function getActionUrl($actionName) {

       return Controller::getActionUrl($actionName);
    }


    /**
     * 加载视图文件的widget
     *
     * @access public
     * @param string  $widgetName 所要加载的widget,没有后缀名
     * @param array   $params 参数
     * @return boolean
     */
    public static function widget($widgetName, $params = null) {

        return Controller::widget($widgetName, $params);
    }

    /**
     * 析构函数
     *
     * @access public
     * @return void
     */
    public function __destruct() {

        if ($this->_options) {
            $this->_options = array();
        }

        $this->cacheStatus = false;
    }

    /**
     * 单例模式实例化本类
     *
     * @access public
     * @return object
     */
    public static function getInstance() {

        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}