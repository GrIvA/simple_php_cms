<?php
// *** VENDOR ***
require_once VENDORDIR . 'Medoo' . DS . 'medoo.php';

// *** CLASS ***
class Database /*extends medoo*/ {
    
    private static $_instance;
    private static $_vendor;

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public static function getField($table, $field, $conditions='') {
        $db = self::$_vendor;
        return  $db->get($table, $field, $conditions);
    }

    public static function log($only_last = true) {
        $db = self::$_vendor;
        if ($only_last) {
            return $db->last_query();
        } else {
            return $db->log();
        }
    }

    // === PRIVATE ===

    private function __construct() {
        global $db_connect;
        if (self::$_instance === null) {
            global $db_connect;
            self::$_vendor = new medoo($db_connect);
        }
    }
}
?>
