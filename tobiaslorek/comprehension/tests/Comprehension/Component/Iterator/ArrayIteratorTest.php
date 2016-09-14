<?php
use \Comprehension\Component\Iterator\ArrayIterator;

class ArrayIteratorTest extends \PHPUnit_Framework_TestCase
{
	public function test__construct()
	{
		$a = [1,2,3];
		$ai = new ArrayIterator($a);
		$this->assertEquals($ai->current(), 1, "first value should be 1");
		$this->assertEquals($ai->key(), 0, "first key should be 0");
		$ai->next();
		$this->assertEquals($ai->current(), 2, "second value should be 2");
		$ai->rewind();
		$this->assertEquals($ai->current(), 1, "should rewind to 1");
		$a = ["ad", "asd"];
		$this->assertEquals($ai->current(), "ad", "should update with reference");
		$ai->next();
		$ai->next();
		$this->assertEquals($ai->valid(), false, "past end of array should be invalid");
	}

	public function testkey()
	{
		//Write Test
	}

	public function testnext()
	{
		//Write Test
	}

	public function testcurrent()
	{
		//Write Test
	}

	public function testvalid()
	{
		//Write Test
	}

	public function testrewind()
	{
		//Write Test
	}

	public function testcontains()
	{
		//Write Test
	}

}

