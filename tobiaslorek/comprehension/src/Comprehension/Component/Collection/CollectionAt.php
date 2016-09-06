<?php

namespace Comprehension\Component\Collection;

/**
 * Class ContainerAtVar
 * @author Tobias Lorek
 */
class CollectionAt
{
	abstract protected function index();
	private $inner;

	/**
	 * @param ArrayIterator|ArrayAccess &$collection
     * @param mixed $index
	 */
	public function __construct(&$collection)
	{
		$this->inner =& $collection;
	}

	/**
	* Retrieve the collection stored at index
	* @return Array|ArrayIterator|ArrayAccess|Iterator
	 */
	public function collection()
	{
		return $this->sanitize($this->collection[$this->index()]);
	}

	private function sanitize(&$output)
	{
		if (is_array($output)) {
			return new ArrayIterator($output);
		} elseif (is_string($output)) {
			return new StringIterator($output);
		} elseif ($output instanceOf \Iterator) {
			return $output;
		} else {
			throw new ElementAtExecption(
				"Value at index must be a collection, either an array, iterator or string",
				$index,
				$collection
			);
		}
	}
}
