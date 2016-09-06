<?php
namespace Comprehension;

abstract class Comprehension {
	private $prev;
	protected static function falsy()
	{
		return false;
	}

	protected static function unity()
	{
	}

	protected static function is_array_or_alike($var)
	{
		return is_array($var) || ($var instanceof ArrayAccess  && $var instanceof Traversable);
	}

	public function __construct(Comprehension prev = null)
	{
		$this->prev = $prev;
	}

	/**
	 * Get the previous comprehension segment
	 *
	 * @return Comprehension
	 */
	protected function prev()
	{
		return $this->prev;
	}


	protected function move()
	{
		$res = $this->moveCurrent();
		if (!$res) {
			if (!is_null($this->prev)) {
				$res = $this->prev->move();
			if ($res) {
				$this->sanitize();
				$this->rewindCurrent();
			}
		}
		return $res;
	}

	/**
	 * Rewinds the comprehension
	 */
	private function rewindAll()
	{
		$this->prev->rewindAll();
		$this->rewindCurrent();
	}

	/**
	 * Moves the comprehension one step foreward
	 */
	abstract protected function moveCurrent();

	/**
	 * Sanatizes the input, wraps strings in string iterators and arrays in array iterators
	 */
	abstract protected function sanitize();

	/**
	 * Restarts the comprehension. Used internally and by the final iterator it generates
	 */
	abstract protected function rewindCurrent();


	/**
	 * Starts building the comprehension by specifying a variable to bind to a context
	 * @param mixed &$assignment
	 * @return Assignemnt
	 */
	static function _forKV(&$key, &$value)
	{
		return new Assignment(null, $value, $key);
	}

	static function _for(&$value)
	{
		return new Assignment(null, $value);
	}

	/**
	 * Continues the comprehension by specifying yet an other varible to bind
	 * @param mixed &$assignment
	 * @return Assignemnt
	 */
	public function _and(&$value) 
	{
		return new Assignemnt($this, $value);
	}
	/**
	 * Continues the comprehension by specifying yet an other varible to bind
	 * @param mixed &$assignment
	 * @return Assignemnt
	 */
	public function _andKV(&$key, &$value) 
	{
		return new Assignemnt($this, $value, $key);
	}

	/**
	 * Filters out values from the comprehension using a callable operating on bound variables.
	 * Up to 10 variables may be used in the function, they must be passed by reference
	 * @param callable $callable function to use
	 * @param mixed &$a mixed first argument for callable
	 * @param mixed &$b mixed second argument for callable
	 * @param mixed &$c mixed third argument for callable
	 * @param mixed &$d mixed forth argument for callable
	 * @param mixed &$e mixed fifth argument for callable
	 * @param mixed &$f mixed sixth argument for callable
	 * @param mixed &$g mixed seventh argument for callable
	 * @param mixed &$h mixed eighth argument for callable
	 * @param mixed &$i mixed ninth argument for callable
	 * @param mixed &$j mixed tenth argument for callable
	 * @return Comprehension
	 */
	public function _where($callable,
		&$a = null,
		&$b = null,
		&$c = null,
		&$d = null,
		&$e = null,
		&$f = null,
		&$g = null,
		&$h = null,
		&$i = null,
		&$j = null
	) 
	{
		return new Where($this, $callable, $a , $b, $c, $d, $e, $f, $g, $h, $i, $j);
	}

	/**
	 * Get the iterator generated by applying a callabe to the bound variables of the comprehension
	 * Up to 10 variables may be used in the function, they must be passed by reference
	 * @param callable $callable function to use
	 * @param mixed &$a mixed first argument for callable
	 * @param mixed &$b mixed second argument for callable
	 * @param mixed &$c mixed third argument for callable
	 * @param mixed &$d mixed forth argument for callable
	 * @param mixed &$e mixed fifth argument for callable
	 * @param mixed &$f mixed sixth argument for callable
	 * @param mixed &$g mixed seventh argument for callable
	 * @param mixed &$h mixed eighth argument for callable
	 * @param mixed &$i mixed ninth argument for callable
	 * @param mixed &$j mixed tenth argument for callable
	 * @return Iterator
	 */
	public function get($callable = null,
		&$a = null,
		&$b = null,
		&$c = null,
		&$d = null,
		&$e = null,
		&$f = null,
		&$g = null,
		&$h = null,
		&$i = null,
		&$j = null
	)
	{
		return new ComprehensionIterator($this, $callable, $a, $b, $c , $d, $e, $f, $g, $h, $i, $j);
	}

	/**
	 * Updates bound variables to their next state
	 * @return Boolean false if all states have been passed.
	 */
	public function next()
	{
		return $this->move();
	}

	/**
	 * Rewinds the comprehension to its initial state
	 */
	public function reset()
	{
		$this->rewindAll();
	}
}

