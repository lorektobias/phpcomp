<?php
use \Comprehension\Component\Iterator\StringIterator;

class StringIteratorTest extends \PHPUnit_Framework_TestCase
{
	private $string = "init";
	public function test__construct()
	{
		$st = new StringIterator($this->string);
		return $st;
	}

	/**
	 * @depends testkey
	 */
	public function testnext(StringIterator $st)
	{
		$st->next();
		$this->assertEquals($st->current(), "n", "secont char of init should be n");
		return $st;
	}

	/**
	 * @depends testcurrent
	 */
	public function testkey(StringIterator $st)
	{
		$this->assertEquals($st->key, 0, "first key should be 0");
		return $st;
	}

	/**
	 * @depends test__construct
	 */
	public function testcurrent(StringIterator $st)
	{
		$this->assertEquals($st->current(), "i", "first letter of init should be i");
		return $st;
	}


	/**
	 * @depends testnext
	 */
	public function testvalid(StringIterator $st)
	{
		$this->assertEquals($st->valid(), true, "second val should be valid");
		$st->next();
		$st->next();
		$st->next();
		$this->assertEquals($st->valid(), false, "fifth val should not be valid");
		return $st;
	}

	/**
	 * @depends testvalid
	 */
	public function testrewind(StringIterator $st)
	{
		$st->rewind();
		$this->assertEquals($st->current(), "i", "first letter of init should be i");
		$this->init = "sec";
		$this->assertEquals($st->current(), "s", "first letter of sec should be s");
	}
}

