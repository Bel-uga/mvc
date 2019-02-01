<?php
error_reporting (E_ALL); 

use DB\Connect;
use Classes\Router;

include ('config.php');
include (SITE_PATH . DS . 'Core' . DS . 'Core.php'); 

$dbObject = new Connect();


$router = new Router();
$router->setPath (SITE_PATH . 'Controllers');
$router->start();
