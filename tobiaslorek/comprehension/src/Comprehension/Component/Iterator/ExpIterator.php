<?php

namespace Comprehension\Component\Iterartor;

/**
 *  * Class expIterator
 *   * @author Tobias Lorek
 *    */
class ExpIterator implements TupledIterator
{
	private $rawDomain;
	private $validPos;
	private $domain;
	private $codomain;
	private $cache;
	private $indices;
	private $done;

	/**
	 * @param Iterator $codomain
     * @param \Iterator|int $domain
	 */
	public function __construct(\Iterator $codomain, &$domain)
	{
        $this->codomain = $codomain;
        $this->rawDomain = $domain;
	}
	
	private function init()

	{
		$this->cache = [];
		$this->indices = [];
		$this->done = false;
		$this->validPos = true;
	
		$this->domain = is_int($this->rawDomain) ? range(0, $this->rawDomain) : $this->rawDomain;
		$this->cache[0] = $this->codomain->current();
		foreach($this->domain as $pos) {
			$this->indices[$pos] = 0;
		}
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		if (!$this->done) {
			$this->done = $this->pushToCache();
		}
		$this->moveTuple();
	}

	/**
	 *  * puches a new Element of the input iterator to the cache
	 *   *
	 *    * @return void
	 *     */
	private function pushToCache()
	{
		$this->codomain->next();
		if ($this->codomain->valid()) {
			$this->cache[] = $this->codomain->current();
		} else {
			$this->done = true;
		}
	}
	

	/**
	 *  * advances the exp iterator
	 *   *
	 *    * @return void
	 *     */
	private function moveTuple()
	{
		$this->validPos = false;
		foreach($this->domain as $pos) {
			if (isset($this->cache[$this->indices[$pos] + 1])) {
				$this->indices[$pos]++;
				$this->validPos = true;
				break;
			} else {
				$this->indices[$pos] = 0;
			}
		}
	}

	public function key()
	{
		return $this->indices;
	}
	
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		$tuple = [];
		foreach ($this->domain as $pos) {
			array_push($tuple, $this->cache[$this->indices[$pos]);
		}
		return $tuple;
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->validPos;
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->init();
	}
}
