<?php
namespace Classes;

class Template
{
    private $controller;
    private $layouts;
    private $vars = array();

    protected function __construct($layouts, $controllerName)
    {
        $this->layouts = $layouts;
        $controllerName = str_replace("Controllers\\", "", $controllerName);
        $controllerName = str_replace("Controller", "", $controllerName);
        $this->controller = strtolower(str_replace("Controller", "", $controllerName));
    }

    public function vars($varname, $value)
    {
        if (isset($this->vars[$varname])) {
            trigger_error('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);
            return false;
        }
        $this->vars[$varname] = $value;
        return true;
    }

    public function view($name)
    {
        $pathLayout = SITE_PATH . 'Views' . DS . 'layouts' . DS . $this->layouts . '.php';
        $contentPage = SITE_PATH . 'Views' . DS . $this->controller . DS . $name . '.php';

        if (file_exists($pathLayout) == false) {
            trigger_error('Layout `' . $this->layouts . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        if (file_exists($contentPage) == false) {
            trigger_error('Template `' . $name . '` does not exist.', E_USER_NOTICE);
            return false;
        }

        foreach ($this->vars as $key => $value) {
            $key = $value;
        }

        include($pathLayout);
    }
}
