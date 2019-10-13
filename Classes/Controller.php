<?php
namespace Classes;

abstract class Controller
{
    protected $template;
    protected $layouts;
    public $vars = array();

    protected function __construct()
    {
        $this->template = new Template($this->layouts, get_class($this));
    }

    abstract function index();
}
