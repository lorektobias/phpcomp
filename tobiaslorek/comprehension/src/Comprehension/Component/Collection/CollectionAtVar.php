<?php

namespace Comprehension\Component\Collection;

/**
 * Class ContainerAtVar
 * @author Tobias Lorek
 */
class CollectionAtVar extends ContainerAt
{
	private $index;
	/**
	 * @param ArrayIterator|ArrayAccess &$collection
     * @param mixed &$index
	 */
	public function __construct(&$collection, &$index)
	{
		parent::__construct($collection);
        $this->index =& $index;
	}
	protected function index()
	{
		return $this->index;
	}
}
