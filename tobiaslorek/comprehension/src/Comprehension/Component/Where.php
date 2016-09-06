<?php
namespace Comprehension\Component;
class Where extends Comprehension
{
	private $prev;
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

	/**
	 * Creates a filter for the bound variables in previous parts of the comprehension using a function and up to 10
	 * variables.
	 * All variables must be passed by reference
	 * @param Comprehension $prev
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
	 */

	public function __construct($prev,
		$callable,
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
		$this->prev = $prev;
		$this->callable = $callable;
	   	$this->a =& $a;
	   	$this->b =& $b;
	   	$this->c =& $c;
	   	$this->d =& $d;
	   	$this->e =& $e;
	   	$this->f =& $f;
	   	$this->g =& $g;
	   	$this->h =& $h;
	   	$this->i =& $i;
		$this->j =& $j;
	}

	/**
	 * Updates the bound variables, used internally
	 */
	protected function move() {
		$r = $this->prev->move();
		if ($r) {
			if (!$this->isValid()) {
				return $this->move();
			}
		}
		return $r;
	}

	private function isValid()
	{
		$pred = $this->callable;
		$res =  $pred($this->a,
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
		return $res;
	}

	protected function rewindAll()
	{
		$this->prev->rewindAll();
		if (!$this->isValid()) {
			$this->move();
		}
	}
}
