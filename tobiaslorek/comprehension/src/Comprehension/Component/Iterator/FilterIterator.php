<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class FilterIterator
 * @author Tobias Lorek
 */
class FilterIterator implements \Iterator
{

	/**
	 * @param \Iterator &$inner
     * @param callable $predicate
	 */
	public function __construct(\Iterator &$inner, callable $predicate)
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
		$pred = $this->pred;
		do {
			$this->inner->next();
		} while (!$pred($this->inner->current()));
	}
	
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return $this->inner->current();
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
		$pred = $this->pred;
		$this->inner->rewind();
		if (!$pred($this->current())) {
			$this->next();
		}
	}
}
