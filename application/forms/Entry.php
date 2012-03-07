<?php

class Application_Form_Entry extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an id element
        $this->addElement('hidden', 'id', array(
            'required'   => false,
            'filters'    => array('Zend_Filter_Alnum'),
            'validators' => array(
                array()
            )
        ));

        // Add an title element
        $this->addElement('text', 'title', array(
            'label'      => 'Title:',
            'required'   => true,
            'filters'    => array('StringTrim', 'StripTags'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
            )
        ));

        // Add the body element
        $this->addElement('textarea', 'body', array(
            'label'      => 'Body:',
            'filters'    => array(
                array('StripTags', 'options'=>array('allowTags' => array('b', 'i', 'a')))
            ),
            'required'   => true,
        ));

        /*// Add a captcha
        $this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));*/

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sumbit',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}

