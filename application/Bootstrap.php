<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->headLink()->appendStylesheet("/bootstrap/css/bootstrap.css");
        $view->headLink()->appendStylesheet("/bootstrap/css/bootstrap-responsive.css");
        $view->headScript()->appendFile('/bootstrap/js/bootstrap.js');
    }
}

