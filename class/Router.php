<?php
// *** VENDORS ***
require_once VENDORDIR . 'AutoRouter' . DS . 'AltoRouter.php';

class Router {

    private static $_router;
    private static $_instance = null;

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        $master = self::$_instance;
        return $master::$_router;
    }

    // === PRIVATE ===

    private function __construct($routes = array(), $basePath = '', $matchTypes = array()) {
        self::$_router = new AltoRouter($routes, $basePath, $matchTypes);
        $router = self::$_router;
        $router->setBasePath('');
        $router->addMatchTypes(array('ln' => '[a-z]{2}', 'page'=>'[0-9A-Za-z_-]++'));
    }
}
?>
