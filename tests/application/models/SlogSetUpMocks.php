<?php

class SlogSetUpMocks extends OrbisLib_SetUpMocks
{
    public function mockEntryMapper()
    {

        $mock = $this->setMock("Application_Model_EntryMapper", "Application_Model_DbTable_Entry");
        $testCase = $this->getTestCase();
        $adapter = $this->getAdapter();

        $testData = array("id" => "1",
            "title" => "First Entry",
            "body" => "Long text",
            "created" => "2012-02-20 15:00:00",
        );

        $testDataNew=$testData;
        unset($testDataNew["id"]);
        $testDataNew["created"]=date("Y-m-d h:i:s");

        $testDataUpdate=$testData;
        unset($testDataUpdate["created"]);

        $testData2 = $testData;
        $testData2["id"] = 3;
        $testData2["title"] = "33 korovi";

        $rowsetMap = array(
            array(0, new Zend_Db_Table_Rowset(array("table" => $mock, "data" => array()))),
            array(1, new Zend_Db_Table_Rowset(array("table" => $mock, "data" => array($testData)))),
        );

        $testRowsetAll = new Zend_Db_Table_Rowset(array("table" => $mock,"data" => array($testData, $testData2)));

        $mock->expects($testCase->any())
            ->method("getAdapter")
            ->will($testCase->returnValue($adapter));

        $mock->expects($testCase->any())
            ->method("find")
            ->will($testCase->returnValueMap($rowsetMap));

        $mock->expects($testCase->any())
            ->method("insert")
            ->with($testDataNew)
            ->will($testCase->returnValue(true));

        $mock->expects($testCase->any())
            ->method("update")
            ->with($testDataUpdate, array('id = ?' => "1"))
            ->will($testCase->returnValue(true));

        $mock->expects($testCase->any())
            ->method("delete")
            ->with($adapter->quoteInto("id = ?", 1))
            ->will($testCase->returnValue(true));

        $mock->expects($testCase->any())
            ->method("fetchAll")
            ->will($testCase->returnValue($testRowsetAll));
    }


}