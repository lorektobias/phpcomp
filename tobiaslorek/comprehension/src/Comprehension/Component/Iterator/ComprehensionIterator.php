<?php
namespace Comprehension;
/**
 * Collects the result from a comprehension and places it in an iterator
 */
class ComprehensionIterator implements \Iterator
{
	private $key = 0;
	private $current;
	private $comprehension;
	private $callable;
	private $a;
   	private $b;
   	private $c;
   	private $d;
   	private $e;
   	private $f;
   	private $g;
   	private $h;
   	private $i;
	private $j;

	public static function zip($a, $b, $c, $d, $e, $f, $g, $h, $i, $j)
	{
		return array_reduce(
			func_get_args(),
			function ($acc, $new) {
				if (!is_null($new)) {
					$acc[] = $new;
				}
				return $acc;
			},
			[]
		);
	}

	
	/**
	 * Creates the comprehension iterator by supplying a callable and up to 10 variables it will use as arguments.
	 * If no callable is supplied an array of all the none null $variabes will be returned
	 */
	public function __construct($comprehension,
		$callable = null,
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

	) {
		$this->comprehension = $comprehension;
		$this->callable = is_null($callable) ? ['Comprehension\ComprehensionIterator', 'zip'] : $callable;
	   	$this->a = &$a;
	   	$this->b = &$b;
	   	$this->c = &$c;
	   	$this->d = &$d;
	   	$this->e = &$e;
	   	$this->f = &$f;
	   	$this->g = &$g;
	   	$this->h = &$h;
	   	$this->i = &$i;
		$this->j = &$j;
	}
	public function current()
	{
		return $this->current;
	}
	public function next()
	{
		$this->key++;
		$res = $this->comprehension->moveToNext();
		if ($res) {
			$this->setCurrent();
		}
		else {
			$this->current = false;
		}
		return $res;
	}

	public function key()
	{
		return $this->key;
	}

	public function valid()
	{
		return $this->current !== false;
	}
	public function rewind()
	{
		$this->comprehension->rewindComprehension();
		$this->key = 0;
		$this->setCurrent();
	}
	private function setCurrent()
	{
		$c = $this->callable;
		$this->current = $c(
			$this->a,
			$this->b,
			$this->c,
			$this->d,
			$this->e,
			$this->f,
			$this->g,
			$this->h,
			$this->i,
			$this->j
		);
	}
}
