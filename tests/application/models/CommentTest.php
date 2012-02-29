<?php

/**
 * единый список тестоданных для всех тестов (по обектам)
 */
class Application_Model_CommentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var  Application_Model_Comment
     */
    protected $comment;

    protected $testData;

    public function setUp()
    {
        $this->comment = new Application_Model_Comment();

        $entryData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text in entry",
            "created" => "2012-01-20 11:00:00",
        );

        $entry = new Application_Model_Entry($entryData);

        $this->testData = array("id" => "1",
            "entry" => $entry,
            "body" => "Comment Text",
            "created" => "2012-02-20 15:00:00",
        );
    }

    public function tearDown()
    {
        unset($this->comment);
    }

    /**
     * @expectedException Exception
     */
    public function testSetBadAttributes()
    {
        $this->comment->badAttribute = "Bad Value";
    }

    /**
     * @expectedException Exception
     */
    public function testGetBadAttributes()
    {
        $this->comment->badAttribute;
    }

    public function testUseAttributes()
    {

        $this->comment->id = $this->testData["id"];
        $this->comment->entry = $this->testData["entry"];
        $this->comment->body = $this->testData["body"];
        $this->comment->created = $this->testData["created"];

        $this->assertEquals($this->testData["id"], $this->comment->id);
        $this->assertEquals($this->testData["entry"], $this->comment->entry);
        $this->assertEquals($this->testData["body"], $this->comment->body);
        $this->assertEquals($this->testData["created"], $this->comment->created);
    }

    public function testIntEntry()
    {
       /* $this->comment->entry = $this->testData["entry"]->id;
        $this->assertEquals($this->testData["entry"], $this->comment->entry);
        $this->assertEquals($this->testData["entry"]->id, $this->comment->getEntryId());*/
    }

    public function testSetOptionsOnCreate()
    {
        $entry = new Application_Model_Comment($this->testData);

        $this->assertEquals($this->testData["id"], $entry->id);
        $this->assertEquals($this->testData["entry"], $entry->entry);
        $this->assertEquals($this->testData["body"], $entry->body);
        $this->assertEquals($this->testData["created"], $entry->created);
    }

    public function testToArray()
    {
        $this->comment->setOptions($this->testData);
        $testData=$this->testData;
        $testData["entry"]=$testData["entry"]->id;
        $this->assertEquals($this->testData, $this->comment->toArray());
    }



}

