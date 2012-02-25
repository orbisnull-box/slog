<?php

class Application_Model_Entry
{
    protected $_id;
    protected $_title;
    protected $_body;
    protected $_created;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function setOptions(array $options)
    {
        //$methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }


    public function __set($name, $value)
    {
        $method = "set" . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid Entry class property");
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = "get" . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid Entry class property");
        }
        return $this->$method();
    }

    public function setId($id)
    {
        $this->_id = (int)$id;
        return true;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setTitle($title)
    {
        $this->_title = (string)$title;
        return true;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setBody($body)
    {
        $this->_body = (string)$body;
        return true;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function setCreated($created)
    {
        $this->_created = (string)$created;
        return true;
    }

    public function getCreated()
    {
        return $this->_created;
    }


}

