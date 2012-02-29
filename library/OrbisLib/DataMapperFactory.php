<?php
require_once ("Zend/Loader.php");
/**
 * plugin, singleton, abstact fabric
 */
class OrbisLib_DataMapperFactory
{
    protected static $_instance;

    protected $_dbTableRegistry;

    private function __construct() { /* ... */ }

    private function __clone() { /* ... */ }

    private function __wakeup() { /* ... */ }

    /**
     * @return OrbisLIb_DataMapperFactory
     */
    public static function getInstance() {
        if (is_null(self::$_instance) ) {
            self::$_instance = new OrbisLib_DataMapperFactory;
        }
        return self::$_instance;
    }

    public static function setDbTable($mapperClass, $dbTable)
    {
        $instance = self::getInstance();
        if ($dbTable instanceof Zend_Db_Table_Abstract) {
            $instance->_dbTableRegistry[$mapperClass] = $dbTable;
            return true;
        } else {
            try {
                Zend_Loader::loadClass($dbTable);
                $instance->_dbTableRegistry[$mapperClass] = new $dbTable;
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function getDbTable($mapperClass)
    {
        $instance = self::getInstance();
        if (isSet($instance->_dbTableRegistry[$mapperClass])) {
            return $instance->_dbTableRegistry[$mapperClass];
        } else {
            return null;
        }
    }

    public static function deleteDbTable($mapperClass)
    {
        $instance = self::getInstance();
        if (isSet($instance->_dbTableRegistry[$mapperClass])) {
            unset($instance->_dbTableRegistry[$mapperClass]);
            return true;
        } else {
            return false;
        }
    }

    public static function create($mapperClass)
    {
        $instance = self::getInstance();
        try {
            Zend_Loader::loadClass($mapperClass);
            $mapper = new $mapperClass($instance->getDbTable($mapperClass));
        } catch (Exception $e) {
            $mapper = null;
        }
        return $mapper;
    }

}


