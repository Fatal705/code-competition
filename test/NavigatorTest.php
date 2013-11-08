<?php

class NavigatorTest extends PHPUnit_Framework_TestCase
{
	public function createNavigator($rowsPerPage = 10, $size = 5){
		return new Xiag\Navigator($rowsPerPage, $size);
	}
    public function testZeroRecordsCreateOnePage()
    {
    	$this->assertEquals('[1]', $this->createNavigator()->printAsString(0, 0));
    }
   	public function testDoNotShowMorePagesThanAllowed()
   	{
    	$this->assertEquals('[1] 2 3 4 5', $this->createNavigator()->printAsString(60, 1));
   	}
   	public function testFirstPage()
   	{
    	$this->assertEquals('[1] 2 3 4 5', $this->createNavigator()->printAsString(50, 1));
   	}
   	public function testLastPage()
   	{
    	$this->assertEquals('2 3 4 5 [6]', $this->createNavigator()->printAsString(60, 59));
   	}
 	public function testMorePagesAfterThenBeforeIfOddPagesCount()
   	{
    	$this->assertEquals('1 2 [3] 4 5 6', $this->createNavigator(10, 6)->printAsString(60, 25));
   	}
   	  	
}
 
