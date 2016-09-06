<?php

namespace Comprehension\Component\Collection;

/**
 * Class ContainerAtVar
 * @author Tobias Lorek
 */
class CollectionAtConst extends CollectionAt
{
	private $index;

	/**
	 * @param ArrayIterator|ArrayAccess &$collection
     * @param mixed $index
	 */
	public function __construct(&$collection, $index)
	{
		parent::__construct($collection);
        $this->index = $index;
	}

	/**
	 * get the index of the collection
	 *
	 * @return void
	 */
	protected function index()
	{
		return $this->index;
	}
	
}
