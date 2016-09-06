<?php
namespace Comprehension\Component;
/**
 * Creates a bind context for a variable from function applied to other vaiables
 */
class FunctionApplication extends Comprehension
{
	private $assignment;
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
	private $key;

	/**
	 * Create a context for a bound variable from a callable taking at most 10 variables
	 * All variables must be passed by reference
	 * @param Assignment $assignment
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
	public function __construct($assignment,
		$prev,
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
		$this->assignment = $assignment;
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
		$this->key = 0;
	}

	protected function move() {
		$r = $this->prev->move();
		if ($r) {
			$this->pushValue();
		}
		return $r;
	}

	private function pushValue()
	{
		$c =$this->callable;
		$this->assignment->updateValue($c(
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
		));
		$this->assignment->updateKey($this->key++);
	}

	/**
	 * Rewind the Comprehension
	 * Used internally
	 */
	protected function rewindAll()
	{
		$this->key = 0;
		$this->prev->rewindAll();
		$this->pushValue();
	}
}
