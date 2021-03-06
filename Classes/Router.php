<?php

namespace Classes;

class Router
{
    private $path;
    private $args = array();


    public function setPath($path)
    {
        $path = rtrim($path, '/\\');
        $path .= DS;
        if (is_dir($path) == false) {
            throw new Exception('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    private function getController(&$file, &$controller, &$action, &$args)
    {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        unset($_GET['route']);
        if (empty($route)) {
            $route = 'index';
        }
        $route = trim($route, '/\\');
        $parts = explode('/', $route);



        $cmd_path = $this->path;
        foreach ($parts as $part) {
            $fullpath = $cmd_path . $part;

            if (is_dir($fullpath)) {
                $cmd_path .= $part . DS;
                array_shift($parts);
                continue;
            }

            if (is_file($fullpath . 'Controller.php')) {
                $controller = $part;
                array_shift($parts);
                break;
            }
        }


        if (empty($controller)) {
            $controller = 'index';
        }


        $action = array_shift($parts);
        if (empty($action)) {
            $action = 'index';
        }

        $file = $cmd_path . $controller . 'Controller.php';
        $args = $parts;
    }

    public function start()
    {
        $this->getController($file, $controller, $action, $args);

        if (file_exists($file) == false) {
            die('404 Not Found ');
        }

        include($file);

        $class = 'Controllers\\' . $controller . 'Controller';
        $controller = new $class();

        if (is_callable(array($controller, $action)) == false) {
            die('404 Not Found');
        }

        $controller->$action();
    }
}
