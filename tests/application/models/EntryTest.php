<?php

class Application_Model_EntryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var  Application_Model_Entry
     */
    protected $entry;

    protected $testData;

    public function setUp()
    {
        $this->entry = new Application_Model_Entry();
        $this->testData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-02-20 15:00:00",
        );
    }

    public function tearDown()
    {
        unset($this->entry);
    }

    /**
     * @expectedException Exception
     */
    public function testSetBadAttributes()
    {
        $this->entry->badAttribute = "Bad Value";
    }

    /**
     * @expectedException Exception
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



}

