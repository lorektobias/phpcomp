<?
namespace Comprehension\Component\Iterartor;
class TimesIterator implements \Iterator, TupledIterator
{
	public static function product(\Iterator &$it1, \Iterator &$it2)
	{
		if ($t1 instanceof SummedIterator) {
			return new SummedIterator(self::product($t1->first(), $t2), self::product($t1->second(), $t2);
		} elseif ($t2 instanceof SummedIterator) {
			return new SummedIterator(self::product($t1, $t2->first()), self::product($t1, $t2->second->());
		} else {
			$temp1 = ($t1 instanceof TupledIterator) ? $t1 ? new unitTuple($t1);
			$temp2 = ($t2 instanceof TupledIterator) ? $t2 ? new unitTuple($t2);
			return new timesIterator($t1, $t2);
		}
	}
	/**
	 * @param TupledIterator $factor1
     * @param TupledIterator $factor2
	 */
	public function __construct(TupledIterator $factor1, TupledIterator $factor2)
	{
        $this->factor1 = $factor1;
        $this->factor2 = $factor2;
	}

	public function key()
	{
		return array_merge($this->factor1->keys(), $this->factor2->key());
	}
	
	/**
	 * Advances the iterator one step
	 */
	public function next()
	{
		$this->factor2->next();
		if (!$this->factor2->valid()) {
			$this->factor2->rewind();
			$this->factor1->next();
		}
	}
	/**
	 * Retrieves the current value
	 */
	public function current()
	{
		return array_merge($this->factor1->current(), $this->factor2->current());
	}
	
	/**
	 * Checks if the current state is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->factor2->valid();	
	}
	
	/**
	 * Rewinds the iterator
	 */
	public function rewind()
	{
		$this->factor1->rewind();
		$this->factor2->rewind();
	}
}

