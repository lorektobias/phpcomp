<?php

namespace Comprehension\Component\Iterator;

/**
 * Class StringIterator
 * @author Tobias Lorek
 */
class StringIterator
{
	private $string;
	private $ind;
	/**
	 * @param string &$string
	 */
	public function __construct(&$string)
	{
        $this->string =& $string;
		$this->ind = 0;
	}

	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		$this->ind++;
	}

	public function key()
	{
		return $this->ind;
	}

	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		if ($this->valid()) {
			return $this->string[$this->ind];
		} else {
			return false;
		}
	}

	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->ind < count($this->string);
		
	}

	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->ind = 0;
	}
}
