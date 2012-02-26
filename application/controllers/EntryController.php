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

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Entry();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $entry = new Application_Model_Entry($form->getValues());
                $entryMapper  = new Application_Model_EntryMapper();
                $entryMapper->save($entry);
                return $this->_helper->redirector('list');
            }
        }

        $this->view->form = $form;
    }

    public function showAction()
    {
        if (null === $id = $this->getRequest()->getParam("id")) {
            return$this->_helper->redirector("error", "Error");
        }

        $entry = new Application_Model_Entry();
        $entryMapper = new Application_Model_EntryMapper();
        if (false===$entryMapper->find($id, $entry)) {
            return$this->_helper->redirector("error", "Error");
        } else {
            $this->view->entry=$entry;
        }
    }
}