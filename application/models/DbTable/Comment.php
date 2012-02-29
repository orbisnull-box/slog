<?php

class Application_Model_DbTable_Comment extends Zend_Db_Table_Abstract
{

    protected $_name = 'comment';

    protected $_referenceMap    = array(
        'Entry' => array(
            'columns'           => array('entry'),
            'refTableClass'     => 'Entry',
            'refColumns'        => array('id')
        ),
    );


}

