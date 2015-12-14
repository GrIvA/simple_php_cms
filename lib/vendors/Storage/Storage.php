<?php

namespace Storage;

abstract class Storage
{

    public static $separator = '/';

    /**
     * Storage container
     * @var array
     */
    protected $storage = array();

    protected $container = array();

    /**
     * Set path separator
     * @deprecated
     * @param string $character separator value
     */
    public static function setSeparator($character)
    {
        self::$separator = $character;
    }

    public function container($path)
    {
        $this->set($path, array());
        $this->container = $this->dispatch($path);
    }

    /**
     * Save information
     * @param string $path storage path
     * @param mixed $value data to store
     * @return mixed
     */
    public function set($path, $value)
    {
        $source = $this->dispatch($path);
        $item = &$this->storage;
        foreach ($source as $part) {
            if (!isset($item[$part])) {
                $item[$part] = array();
            }
            $item = &$item[$part];
        }

        return $item = $value;
    }

    /**
     * Get data from storage
     * @param string $path data address in storage
     * @param null|mixed $default value will be returned if data is missing
     * @return mixed|null
     */
    public function get($path, $default = null)
    {
        $source = $this->dispatch($path);
        $value = $this->storage;
        foreach ($source as $part) {
            $value = isset($value[$part]) ? $value[$part] : $default;
            if ($value === $default) {
                break;
            }
        }

        return $value;
    }

    /**
     * Remove data from storage
     * @param string $path data address in storage
     * @return bool
     */
    public function delete($path)
    {
        $source = $this->dispatch($path);
        $value = &$this->storage;
        $last = count($source) - 1;
        foreach ($source as $key => $part) {
            if (isset($value[$part])) {
                if ($last == $key) {
                    unset($value[$part]);
                    return true;
                }
                $value = &$value[$part];
                continue;
            }
            break;
        }

        return false;
    }

    /**
     * Check is address registered in storage
     * @param string $path data address in storage
     * @return bool
     */
    public function has($path)
    {
        return !is_null($this->get($path));
    }

    /**
     * Parse the address in storage
     * @param string $path data address in storage
     * @return array
     */
    private function dispatch($path)
    {
        return array_filter(array_merge($this->container, explode(self::$separator, $path)));
    }

}
