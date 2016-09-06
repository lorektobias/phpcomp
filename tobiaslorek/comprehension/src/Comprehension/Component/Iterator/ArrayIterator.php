<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class ArrayIterator
 * @author Tobias Lorek
 */
class ArrayIterator implements \Iterator, \ArrayAccess
{
	private $array;
	/**
	 * @param array &$array
	 */
	public function __construct(array &$array)
	{
		$this->array =& $array;
	}

	public function key()
	{
		return key($this->array);
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		next($this->array);
	}
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return current($this->array);
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->current() !== false;
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		reset($this->array);
	}

	/**
	 * Check if Inner array is equal to other container
	 */
	public function contains(&$container)
	{
		return $this->array === $container;
	}
}
