<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class FilterIterator
 * @author Tobias Lorek
 */
class MapIterator implements \Iterator
{

	/**
	 * @param \Iterator &$inner
     * @param callable $function
	 */
	public function __construct(\Iterator $inner, callable $function)
	{
        $this->inner = $inner;
        $this->predicate = $predicate;
	}

	public function key()
	{
		return $this->inner->key();
	}	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		$this->inner->next();

	}
	
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		$func = $this->func;
		return $this->func($this->inner->current());
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->inner->valid();
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->inner->rewind();
	}
}
