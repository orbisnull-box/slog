<?php

class Application_Model_CommentMapper
{
    /**
     * @var Application_Model_DbTable_Comment
     */
    protected $_dbTable;

    public function __construct($dbTable = null)
    {
        if (!is_null($dbTable)) {
            $this->setDbTable($dbTable);
        }
    }

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new UnexpectedValueException("Invalid table data gateway provided");
        }
        $this->_dbTable = $dbTable;

        return true;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable("Application_Model_DbTable_Comment");
        }
        return $this->_dbTable;
    }


    public function find($id, Application_Model_Comment $comment)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) === 0) {
            return false;
        } else {
            $row = $result->current();
            $comment->setId($row->id)
                ->setEntry($row->entry)
                ->setBody($row->body)
                ->setCreated($row->created);
            return true;
        }
    }

    public function save(Application_Model_Comment $comment)
    {
        $data = $comment->toArray();
        $id = $comment->getId();
        if ($id === 0) {
            unset($data["id"]);
            return $this->getDbTable()->insert($data);
        } else {
            unset($data["created"]);
            return $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll($where = null)
    {
        $resultSet = $this->getDbTable()->fetchAll($where);
        $comments = array();
        foreach ($resultSet as $row) {
            $comment = new Application_Model_Comment();
            $comment->setId($row->id)
                ->setEntry($row->entry)
                ->setBody($row->body)
                ->setCreated($row->created);
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * @param Application_Model_Entry|string $entry
     * @return array
     */
    public function fetchAllToEntry($entry)
    {
        if($entry instanceof Application_Model_Entry) {
            $entry = $entry->id;
        }
        $where = $this->getDbTable()->getAdapter()->quoteInto("entry = ?", $entry);
        return $this->fetchAll($where);
    }

    public function delete(Application_Model_Comment $entry)
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto("id = ?", $entry->id);
        return $this->getDbTable()->delete($where);
    }


}

