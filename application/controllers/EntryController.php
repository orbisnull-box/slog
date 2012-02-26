<?php

class EntryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_forward("list");
    }

    public function listAction()
    {
        $entry = new Application_Model_EntryMapper();
        $this->view->entries = $entry->fetchAll();
    }


}



