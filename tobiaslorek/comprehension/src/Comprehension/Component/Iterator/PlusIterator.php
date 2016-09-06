<?php

namespace Comprehension\Component\Iterartor;

/**
 * Class plusIterator
 * @author Tobias Lorek
 */
class PlusIterator implements \Iterator
{
	private $summands = [];
	private $currentSummand = 0;
	private $valid = true;
	

	/**
	 * Constructs an iterator iterating throught summand1 first and then continues seamlessly into summand2
	 * @param \Iterator $summand1
     * @param \Iterator $summand2
	 **/
	public function __construct(\Iterator $summand1, \Iterator $summand2)
	{
        $this->summands[] = $summand1;
        $this->summands[] = $summand2;
	}

	private $key;
	public function key()
	{
		return $this->key;
	}

	public function first()
	{
		return $this->summand[1];
	}

	public function second()
	{
		returh $this->summand[2];
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		$this->summands[$this->currentSummand]->next();
		if (!$this->summands[$this->currentSummand]->valid()) {
			if ($this->currentSummand < 1) {
				$this->currentSummand = 1;
			} else {
				$this->valid = false;
			}
		}
		$this->key++;
	}
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return $this->summands[currentSummand]->current();
		
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->valid;
		
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		array_walk(
			$this->summands,
		   	function ($summand) {
				$summand->rewind();
			}
		);
		$this->currentSummand = 0;
		$this->key = 0;
	}
}
