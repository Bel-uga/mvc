<?php

define('DS', DIRECTORY_SEPARATOR);
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define('SITE_PATH', $sitePath);

define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_HOST', 'localhost');
define('DB_NAME', 'test2');
