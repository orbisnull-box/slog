<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'Index', 'module' => 'default');
        $this->dispatch($this->url($this->urlizeOptions($params)));
        $params2 = array('action' => 'index', 'controller' => 'Entry', 'module' => 'default');
        $headers   = $this->getResponse()->getHeaders();

        $this->assertEquals($this->url($this->urlizeOptions($params2)), $headers[0]["value"]);
    }


}



