<?php
require_once("SlogSetUpMocks.php");

class Application_Model_CommentMapperTest extends PHPUnit_Framework_TestCase
{
    protected $dbTableClass = "Application_Model_DbTable_Comment";

    protected $mapperClass = "Application_Model_CommentMapper";

    /**
     * @var Application_Model_CommentMapper
     */
    protected $mapper;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $mock;

    protected $testData;

    protected $_setUpMocksObj;


    protected function setUp()
    {
        $entryData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-01-20 11:00:00",
        );

        $entry = new Application_Model_Entry($entryData);

        $this->testData = array("id" => "1",
            "entry" => $entry,
            "body" => "Long text",
            "created" => "2012-02-20 15:00:00",
        );

        $this->_setUpMocksObj = new SlogSetUpMocks($this);
        $this->_setUpMocksObj->run();
        $this->mock = $this->_setUpMocksObj->getMock($this->mapperClass);

        $this->mapper = OrbisLib_DataMapperFactory::create($this->mapperClass);
    }

    public function tearDown()
    {
        unset($this->mapper);
        unset($this->mock);
        unset($this->_setUpMocksObj);
    }


    public function testDbTable()
    {
        $this->assertEquals($this->mock, $this->mapper->getDbTable(), "Error in Factory load dbTable");

        $this->mapper->setDbTable($this->dbTableClass);
        $this->assertEquals(new $this->dbTableClass, $this->mapper->getDbTable(), "Error in string setDbtable");

        $this->mapper->setDbTable($this->mock);
        $this->assertEquals($this->mock, $this->mapper->getDbTable(), "Error in obj setDbtable");
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testDbTableError()
    {
        $this->mapper->setDbTable(new StdClass);
    }

    public function testFind()
    {
        $comment = new Application_Model_Comment();
        $result = $this->mapper->find(1, $comment);
        $this->assertTrue($result, "Not found entry (id=1)");
        $this->assertEquals(new Application_Model_Comment($this->testData), $comment, "Found other entry");

        $comment = new Application_Model_Comment();
        $result = $this->mapper->find(0, $comment);
        $this->assertFalse($result, "Found missing entry");
    }

    public function testSave()
    {
        $testDataNew=$this->testData;
        unset($testDataNew["id"]);
        $testDataNew["created"]=date("Y-m-d h:i:s");

        $testDataUpdate=$this->testData;
        unset($testDataUpdate["created"]);

        //test insert
        $testDataNew["id"]=0;
        $comment = new Application_Model_Comment($testDataNew);
        $result = $this->mapper->save($comment);
        $this->assertTrue($result);

        //test update
        $testData=$this->testData;
        $comment = new Application_Model_Comment($testData);
        $result = $this->mapper->save($comment);
        $this->assertTrue($result);

    }

    public function testFetchAll()
    {
        $testData2 = $this->testData;
        $testData2["title"] = "33 korovi";

        $entris = array(new Application_Model_Comment($this->testData)
        , new Application_Model_Comment($testData2)
        );

        $this->assertEquals($entris, $this->mapper->fetchAll());
    }

    public function testFetchAllToEntry()
    {
        $entryData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-01-20 11:00:00",
        );

        $testData2 = $this->testData;
        $testData2["title"] = "33 korovi";

        $comments = array(new Application_Model_Comment($this->testData), new Application_Model_Comment($testData2));

        $entry = new Application_Model_Entry($entryData);

        $this->assertEquals($comments, $this->mapper->fetchAllToEntry(1));
        $this->assertEquals($comments, $this->mapper->fetchAllToEntry($entry));
    }

    public function testDelete()
    {
        $entry = new Application_Model_Comment($this->testData);
        $result = $this->mapper->delete($entry);
        $this->assertTrue($result);
    }



}

