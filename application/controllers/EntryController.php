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
        $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
        $this->view->entries = $entryMapper->fetchAll();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Entry();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $entry = new Application_Model_Entry($form->getValues());
                $entry->setId(null);
                $entry->setCreated(date("Y-m-d h:i:s"));
                $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
                $entryMapper->save($entry);
                return $this->_helper->redirector('list');
            }
        }
        $this->view->form = $form;
    }

    public function showAction()
    {
        if (null === $id = $this->getRequest()->getParam("id")) {
            return $this->_helper->redirector("error", "Error");
        }

        $entry = new Application_Model_Entry();
        $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
        if (false === $entryMapper->find($id, $entry)) {
            return $this->_helper->redirector("error", "Error");
        } else {
            $commentMapper = OrbisLib_DataMapperFactory::create("Application_Model_CommentMapper");
            $comments = $commentMapper->fetchAllToEntry($entry);
            $this->view->entry = $entry;
            $this->view->comments = $comments;
        }
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Entry();
        $entry = new Application_Model_Entry();
        $entryMapper  = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
        if ($request->isPost()) {
            if ($form->isValid($request->getPost()) and $form->getValue("id")!==null) {
                $entry->setOptions($form->getValues());
                $entryMapper->save($entry);
                return $this->_helper->redirector('list');
            }
        } else {
            if ((null === $id = $request->getParam("id")) or (false === $entryMapper->find($id, $entry))) {
                return $this->_helper->redirector("error", "Error");
            }
            $form->setDefaults($entry->toArray());
        }
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        if (null === $id = $this->getRequest()->getParam("id")) {
            return $this->_helper->redirector("error", "Error");
        }

        $entry = new Application_Model_Entry();
        $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
        if (false === $entryMapper->find($id, $entry)) {
            return $this->_helper->redirector("error", "Error");
        } else {
            $entryMapper->delete($entry);
            return $this->_helper->redirector('list');
        }
    }


}



