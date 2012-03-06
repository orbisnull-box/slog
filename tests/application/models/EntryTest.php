<?php

class Application_Model_EntryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var  Application_Model_Entry
     */
    protected $entry;

    protected $testData;

    /**
     * @var OrbisLib_SetUpMocks
     */
    protected $_setUpMocksObj;


    public function setUp()
    {
        $this->entry = new Application_Model_Entry();
        $this->testData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-02-20 15:00:00",
        );

        $this->_setUpMocksObj = new SlogSetUpMocks($this);
        $this->_setUpMocksObj->run();
    }

    public function tearDown()
    {
        unset($this->entry);
        unset($this->_setUpMocksObj);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testSetBadAttributes()
    {
        $this->entry->badAttribute = "Bad Value";
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testGetBadAttributes()
    {
        $this->entry->badAttribute;
    }

    public function testUseAttributes()
    {

        $this->entry->id = $this->testData["id"];
        $this->entry->title = $this->testData["title"];
        $this->entry->body = $this->testData["body"];
        $this->entry->created = $this->testData["created"];

        $this->assertEquals($this->testData["id"], $this->entry->id);
        $this->assertEquals($this->testData["title"], $this->entry->title);
        $this->assertEquals($this->testData["body"], $this->entry->body);
        $this->assertEquals($this->testData["created"], $this->entry->created);
    }

    public function testSetOptionsOnCreate()
    {
        $entry = new Application_Model_Entry($this->testData);

        $this->assertEquals($this->testData["id"], $entry->id);
        $this->assertEquals($this->testData["title"], $entry->title);
        $this->assertEquals($this->testData["body"], $entry->body);
        $this->assertEquals($this->testData["created"], $entry->created);
    }

    public function testToArray()
    {
        $this->entry->setOptions($this->testData);
        $this->assertEquals($this->testData, $this->entry->toArray());
    }

    public function testComments()
    {
        $entryData = array("id" => 1,
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-01-20 11:00:00",
        );

        $entry = new Application_Model_Entry($entryData);

        $testData = array("id" => "1",
            "entry" => $entry,
            "body" => "Long text",
            "created" => "2012-02-20 15:00:00",
        );
        $testData2 = $testData;
        $testData2["title"] = "33 korovi";

        $comments = array(new Application_Model_Comment($testData), new Application_Model_Comment($testData2));

        $this->assertEquals($comments, $entry->comments);
    }



}

