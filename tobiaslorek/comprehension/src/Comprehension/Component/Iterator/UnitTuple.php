<?php
namespace Comprehension\Component\Iterators;

/**
 * Class unitTuple
 * @author Tobias Lorek
 */
class UnitTuple implements TupledIterator
{
	private $inner;
	/**
	 * Wraps an iteraror so it returns iterators containing its return values
	 *
	 * @return void
	 */
	public function __construct(Iterator &$inner)	
	{
		$this->inner =& $inner;	
	}
	/**
	 * Advances the iterator on position
	 *
	 * @return void
	 */
	public function next()
	{
		$this->inner->next();
	}
	/**
	 * Returns the current element in the iterator
	 *
	 * @return unitIterator
	 */
	public function current()
	{
		return new [$this->inner->current()];
	}
	/**
	 * Checks if the iterator is in a vaild state
	 *
	 * @return boolean
	 */
	public function vaild()
	{
		$this->inner->valid();
	}
	/**
	 * Rewinds the iterator
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->inner->rewind();
	}
	public function key()
	{
		return [$this->inner->key()];
	}
}
