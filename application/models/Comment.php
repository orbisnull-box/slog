<?php

class Application_Model_Comment
{
    protected $_id;
    /**
     * @var Application_Model_Entry
     */
    protected $_entry;
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
            throw new UnexpectedValueException("Invalid Comment set class property: \"$name\"");
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = "get" . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new UnexpectedValueException("Invalid Comment get class property: \"$name\"");
        }
        return $this->$method();
    }



    public function setId($id)
    {
        $this->_id = (int)$id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setEntry($entry)
    {
        $this->_entry = $entry;
        return $this;
    }

    public function getEntry()
    {
        if (isSet($this->_entry) and (!$this->_entry instanceof Application_Model_Entry)) {
            $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
            $entry = new Application_Model_Entry();
            if ($entryMapper->find($this->_entry, $entry)) {
                $this->_entry = $entry;
            } else {
                $this->_entry = null;
            }
        }
        return $this->_entry;
    }

    public function getEntryId()
    {
        if ($this->_entry instanceof Application_Model_Entry) {
            return $this->_entry->id;
        } else {
            return $this->_entry;
        }
    }

    public function setBody($body)
    {
        $this->_body = (string)$body;
        return $this;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function setCreated($created)
    {
        $this->_created = (string)$created;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
    }

    public function toArray()
    {
        $vars=get_class_vars(__CLASS__);
        $data=array();
        foreach ($vars as $key=>$value) {
            $name = substr($key,1);
            $method = "get" . ucfirst($name);

            if(method_exists($this, $method."Id")){
                $method=$method."Id";
            }

            if (method_exists($this, $method))  {
                $data[$name] = $this->$method();
            }
        }
        return $data;
    }



}

