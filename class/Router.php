<?php
// *** VENDORS ***
require_once VENDORDIR . 'AutoRouter' . DS . 'AltoRouter.php';

class Router extends AltoRouter {

    public function __construct($routes = array(), $basePath = '', $matchTypes = array()) {
        parent::__construct($routes, $basePath, $matchTypes);
        $this->addMatchTypes(array('ln' => '[a-z]{2}'));
    }
}
?>
