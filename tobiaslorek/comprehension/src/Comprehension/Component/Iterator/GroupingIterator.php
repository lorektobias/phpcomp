<?php

namespace ;

/**
 * Class GroupingIterator
 * @author Tobias Lorek
 */
class GroupingIterator implements \Iterator
{
	private $offset = 0;
	private $done = false;
	private $grouper;
	private $outer;
	private $index;
	private $groups;
	/**
	 * @param \Iterator $outer
     * @param callable $grouper
	 */
	public function __construct(\Iterator $outer, callable $grouper)
	{
        $this->outer = $outer;
		$this->groups = new ArrayIterator();
        $this->grouper = $grouper;
	}
	
	public function is_done()
	{
		return $this->done;
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		while(!($this->groups->offsetExists($this->offset + 1) || $this->done)) {
			$this->addValueToGroups();
		}
		$this->groups->next();
		$this->offset++;
	}

	public function key()
	{
		return $this->groups->key();
	}

	private function pushMore($group)
	{
		do {
			$reciever = $this->addValueToGroups();
		} while ($group != $reciever);
	}

	private function addValueToGroups()
	{
		$this->outer->next();
		$val = $this->outer->current();
		$grouper = $this->grouper;
		$key = $grouper($value);
		if (isset($this->index[$key])) {
			$group = $this->groups[$this->index[$key]];
		} else {
			$group = new GroupedIterator($this);
			$ind = count($this->index);
			$this->index[$key] = $ind;
			$this->groups[$ind] = new GroupedIterator($this);
		}
		$group->addValue($value);
		return $group;
	}

			
		
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return $this->groups->current();
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->groups->valid();
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->groups->rewind();
	}
}
