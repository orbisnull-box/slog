<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $params = array('action' => 'index', 'controller' => 'Entry', 'module' => 'default');
        $url=$this->_helper->Url->url($params, null, true);
        $this->_redirect($url);
    }


}

