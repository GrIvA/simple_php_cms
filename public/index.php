<?php
// @codingStandartIgnoreStart
define('DS', DIRECTORY_SEPARATOR);
define('WEBDIR', dirname(__FILE__) . DS);
define('ROOTDIR', dirname(WEBDIR) . DS);
define('LIBDIR', ROOTDIR . 'lib' . DS);
// @codingStandartIgnoreEnd

require_once LIBDIR . 'declarations.php';
require_once LIBDIR . 'misc_function.php';

// start autoloader
require_once LIBDIR . 'autoloader.php';
autoloader(array(
    array(
        'debug'    => DEVELOP,
        'basepath' => [CLASSDIR, VENDORDIR]
    )
));
require_once LIBDIR . 'config.php';

// fix load router misc function
include_once VENDORDIR . '/FastRoute/functions.php';

// error mode
if (DEVELOP) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_STRICT);
    //error_reporting(-1);
}

// Prepare app
$app = new Slim\App(['settings' => ['config' => $container]]);

// add middleware
require_once LIBDIR . 'middleware.php';

// Define routes
require_once LIBDIR . 'routes.php';

// Run app
$app->run();
