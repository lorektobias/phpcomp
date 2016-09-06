<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class GroupedIterator
 * @author Tobias Lorek
 */
class GroupedIterator implements \Iterator
{
	private $inner;
	private $outer;
	private $done = false;
	private $offset = -1;

	/**
	 * @param GroupingIterator $outer
	 */
	public function __construct(GroupingIterator $outer)
	{
		$this->inner = new \ArrayIterator()
        $this->outer = $outer;
	}
	
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		if ($this->done) {
			$this->inner->next();
		} elseif ($this->inner->offsetExists($this->offset + 1)) {
			$this->inner->next();
			$this->offset++;
		} else {
			$this->done = !$this->outer->pushMore($this);
			$this->next();
		}
	}


	public function key()
	{
		return $this->inner->key();
	}

	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		$this->inner[$this->offset];
	}

	public function recieve($elem)
	{
		$this->offset++
		$this->inner[$this->offset] = $elem;
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		$this->inner->valid();
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->inner->rewind();
	}
}
