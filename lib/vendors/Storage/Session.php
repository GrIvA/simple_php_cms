<?php

namespace Storage;

class Session extends Storage
{

    /**
     * Singleton
     * @var Session
     */
    private static $instance = null;

    /**
     * Get class instance
     * @return Session
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Update the session information
     */
    public function __destruct()
    {
        $_SESSION = $this->storage;
    }

    /**
     * Retrieve the session in to the storage container
     */
    private function __construct()
    {
        if (!session_id()) {
            session_start();
        }
        $this->storage = &$_SESSION;
    }

    private function __clone()
    {
        throw new \Exception('Cannot clone singleton object');
    }

    private function __wakeup()
    {
        throw new \Exception('Cannot unserialize singleton object');
    }

}
