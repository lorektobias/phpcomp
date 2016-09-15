<?php
namespace Comprehension\Component\Iterator;

use Comprehension\Component\Collection\CollectionAt;

class atIteratorIterator implements \Iterator
{
	private $collection;
	/**
	 * @param ContainerAt $collection
	 */
	public function __construct(CollectionAt $collection)
	{
        $this->collection = $collection;
	}
	
	protected function collection()
	{
		return $this->collection->collection();
	}

	protected function contains(&$collection)
	{
		return $this->collection->contains($collection);
	}

	public function next()
	{
		$this->collection()->next();
	}

	public function key()
	{
		$this->collection()->key();
	}

	public function valid()
	{
		return $this->collection()->valid();
	}

	public function current()
	{
		return $this->collection()->current();
	}

	public function rewind()
	{
		$this->collection()->rewind();
	}
}
