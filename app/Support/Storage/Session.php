<?php

namespace App\Support\Storage;

use Countable;
use App\Support\Storage\Contracts\StorageInterface;

class Session implements StorageInterface, Countable
{
    protected $storage;

    public function __construct($storage = 'default')
    {
        if (!isset($_SESSION[$storage])) {
            $_SESSION[$storage] = [];
        }

        $this->storage = $storage;
    }

    public function set($index, $value)
    {
        $_SESSION[$this->storage][$index] = $value;
    }

    public function get($index)
    {
        if (!$this->exists($index)) {
            return null;
        }

        return $_SESSION[$this->storage][$index];
    }

    public function exists($index)
    {
        return isset($_SESSION[$this->storage][$index]);
    }

    public function all()
    {
        return $_SESSION[$this->storage];
    }

    public function unset($index)
    {
        if ($this->exists($index)) {
            unset($_SESSION[$this->storage][$index]);
        }
    }

    public function clear()
    {
        unset($_SESSION[$this->storage]);
    }

    public function count()
    {
        return count($this->all());
    }
}
