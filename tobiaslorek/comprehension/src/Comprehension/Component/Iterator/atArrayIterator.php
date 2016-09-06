<?php

namespace Comprehension\Component\Iterartor;
class atArrayIterator extends atIteratorIterator implements \ArrayAccess
{

	/**
	 * @param ContainerAt $collection
	 */
	public function __construct(CollectionAt $collection)
	{
		parent::__construct($collection);
	}
	
	public function offsetExists($offset)
	{
		return isset($this->collection()[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->collection()[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$collection =& $this->collection();
		$collection[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		$collection =& $this->collection();
		unset($collection[$offset]);
	}
}
