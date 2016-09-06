<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class FilterIterator
 * @author Tobias Lorek
 */
class ScanIterator implements \Iterator
{

	private $inner;
	private $scanner;
	private $inital;
	private $accumilator;
	/**
	 * @param \Iterator &$inner
     * @param callable $scanner
	 */
	public function __construct(\Iterator $inner, callable $scanner, $inital)
	{
        $this->inner = $inner;
        $this->scanner = $scanner;
		$this->inital = $initial;
	}

	public function key()
	{
		return $this->inner->key();
	}

	private function init()
	{
		$this->inner->rewind();
		$this->accumilator = $this->inital;
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		$scanner = $this->scanner;
		$this->inner->next();
		if ($this->inner->valid()) {
			$this->accumilator = $scanner($this->accumilator, $this->inner->current());
		}
	}
	
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return $this->accumilator;
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
		$this->init();
	}
}
