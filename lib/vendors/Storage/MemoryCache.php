<?php

namespace Storage;

class MemoryCache extends Storage
{

    /**
     * @var \Memcached
     */
    private $memcache;

    private $storage_key = 'storage';

    /**
     * Initialize the memcached connection
     * @param string $server memcached server address
     * @param int $port server port number
     */
    public function __construct($server, $port)
    {
        $this->memcache = new \Memcached();
        $this->memcache->addServer($server, $port);
        $this->storage = $this->memcache->get($this->storage_key);
    }

    /**
     * Synchronize memcached and storage container
     */
    public function __destruct()
    {
        $this->memcache->set($this->storage_key, $this->storage);
    }

}