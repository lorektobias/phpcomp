<?php
namespace Comprehension\Component;
/**
 * Creates a bind context for a variable from partial reductions of up to 10 bound variables
 */
class Scan extends Comprehension
{
	private $assignment;
	private $prev;
	private $callable;
	private $inital;
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
	private $acc;

	/**
	 * Creates a bind context for a variable from partial reductions of up to 10 bound variables
	 * All variables must be passed by reference
	 * @param Assignment $assignment
	 * @param Comprehension $prev
	 * @param callable $callable function to use
	 * @param mixed $initial initial value
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
		$initial,
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
		$this->inital = $inital;
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
		$this->acc = $this->inital;
		$this->push();
	}

	protected function move() {
		$r = $this->prev->move();
		if ($r) {
			$this->push();
		}
		return $r;
	}

	private function push()
	{
		$c =$this->callable;
		$this->acc = $c(
			$this->acc,
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
		$this->assignment->updateValue($this->acc);
		$this->assignment->updateKey($this->key++);
	}

	/**
	 * Rewind the Comprehension
	 * Used internally
	 */
	protected function rewindAll()
	{
		$this->key = 0;
		$this->acc = $this->initial;
		$this->prev->rewindAll();
		$this->push();
	}
}
