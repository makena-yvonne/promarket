<?php

class Request
{
    protected static $instance = null;
    protected $params = [];

    protected function __construct()
    {
        foreach ($_GET as $key => $value) {
            $this->params[$key] = $value;
        }

        foreach ($_POST as $key => $value) {
            $this->params[$key] = $value;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function get($key = null, $default = null)
    {
        if ($key == null) {
            return $this->all();
        }
        return (isset($this->params[$key])) ? $this->params[$key] : $default;
    }

    public function all()
    {
        return $this->params;
    }

    public function except($key)
    {
        $params = $this->all();
        unset($params[$key]);
        return $params;
    }
}