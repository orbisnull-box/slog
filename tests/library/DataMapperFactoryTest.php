<?php
class OrbisLib_DataMapperFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $testMapper;
    protected $dbTable;
    protected $mock;

    public function setUp()
    {
        $this->testMapper = new Application_Model_EntryMapper();
        $this->dbTable = new Application_Model_DbTable_Entry();
        $this->mock = $this->getMock("Application_Model_DbTable_Entry");
        OrbisLib_DataMapperFactory::deleteDbTable("Application_Model_EntryMapper");
    }

    public function testCreate()
    {
        $entryMapper = OrbisLib_DataMapperFactory::create("Application_Model_EntryMapper");
        $this->assertEquals($this->testMapper, $entryMapper);
        $this->assertNull(OrbisLib_DataMapperFactory::create("FakeStupidMapper"));
    }

    public function testDbTable()
    {
        //string
        $result  = OrbisLib_DataMapperFactory::setDbTable("Application_Model_EntryMapper", "Application_Model_DbTable_Entry");
        $this->assertEquals($this->dbTable, OrbisLib_DataMapperFactory::getDbTable("Application_Model_EntryMapper"));
        $this->assertTrue($result);

        $result  = OrbisLib_DataMapperFactory::setDbTable("Application_Model_EntryMapper", "FakeStupidTable");
        $this->assertFalse($result);

        //delete
        $result  = OrbisLib_DataMapperFactory::deleteDbTable("Application_Model_EntryMapper");
        $this->assertEquals(null, OrbisLib_DataMapperFactory::getDbTable("Application_Model_EntryMapper"));
        $this->assertTrue($result);
        $result  = OrbisLib_DataMapperFactory::deleteDbTable("Application_Model_EntryMapper");
        $this->assertFalse($result);

        //null get
        $result = OrbisLib_DataMapperFactory::getDbTable("Application_Model_EntryMapper");
        $this->assertNull($result);

        //object
        $result  = OrbisLib_DataMapperFactory::setDbTable("Application_Model_EntryMapper", $this->dbTable);
        $this->assertEquals($this->dbTable, OrbisLib_DataMapperFactory::getDbTable("Application_Model_EntryMapper"));
        $this->assertTrue($result);

        //mock
        $result  = OrbisLib_DataMapperFactory::setDbTable("Application_Model_EntryMapper", $this->mock);
        $this->assertEquals($this->mock, OrbisLib_DataMapperFactory::getDbTable("Application_Model_EntryMapper"));
        $this->assertTrue($result);


    }

    //errors
}