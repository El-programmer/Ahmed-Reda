<?php

namespace PHPMVC\Controllers;


use PHPMVC\LIB\FrontController;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;

class AbstractController
{
    use Inputfilter;
    use Helper;

    protected $_controller;
    protected $_action;
    protected $_param;
    protected $_data = [];

    protected $_template;
    protected $_registry;

    public function __get($key)
    {
        return $this->_registry->$key;
    }

    public function notFoundAction()
    {
        $this->_view();
    }

    public function setController($controllerName)
    {
        $this->_controller = $controllerName;
    }

    public function setAction($ActionName)
    {
        $this->_action = $ActionName;
    }

    public function settemplate($template)
    {

        $this->_template = $template;
    }

    public function setregistry($registry)
    {
        $this->_registry = $registry;
    }

    public function setParam($param)
    {
        $this->_param = $param;
    }

    protected function _view()
    {


        // $this->_language->load( __CLASS__);
        $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        if ($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        }

        $this->_data = array_merge($this->_data, $this->language->getdictionary());
        $this->_template->setActionView($view);
        $this->_template->setData($this->_data);
        $this->_template->setregistry($this->_registry);

        $this->_template->randerApp();
    }

    protected function _viewajax()
    {
        $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        //require_once($view);
        if ($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        }
        $this->_data = array_merge($this->_data, $this->_language->getdictionary());
        $this->_template->setActionView($view);
        $this->_template->setData($this->_data);
        $this->_template->setregistry($this->_registry);
        $this->_template->randerAppajax();
    }
    protected function _viewjson(array  $data){
        echo json_encode($data);
        exit;
    }
    protected function _viewText(  $data){
        echo $data;
        exit;
    }
    public function pre($item)
    {
        echo "<pre>";
        print_r($item);
        echo "</pre>";
    }


}