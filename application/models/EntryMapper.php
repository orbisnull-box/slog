<?php

class Application_Model_EntryMapper
{
    /**
     * @var Application_Model_DbTable_Entry
     */
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway provided");
        }
        $this->_dbTable = $dbTable;

        return true;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable("Application_Model_DbTable_Entry");
        }
        return $this->_dbTable;
    }


    public function find($id,  Application_Model_Entry $entry)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) === 0) {
            return false;
        } else {
            $row = $result->current();
            $entry->setId($row->id)
                ->setTitle($row->title)
                ->setBody($row->body)
                ->setCreated($row->created);
            return true;
        }
    }

    public function save(Application_Model_Entry $entry)
    {
        $data=$entry->toArray();
        $id = $entry->getId();
        if ($id === null) {
            unset($data["id"]);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Entry();
            $entry->setId($row->id)
                ->setTitle($row->title)
                ->setBody($row->body)
                ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;
    }


}

