<?php
namespace Comprehension\Component;
/*
 * Allows you to specifiy an bound variable to some context
 */
class Assignment
{

	private $prev, $valueVar, $keyVar;
	/**
	 * Constructs an assignment of a variable passed by references as a bound variable to a context
	 * @param Comprehension $prev previous specified comprenesio
	 * @param mixed &$var $variable name to use for binding
	 */
	public function __construct($prev, &$value, &$key = null)
	{
		if (!is_null($value)) {
			throw new BoundVariableException("Can not reasign already bound variable", $value);
		}
			if (!is_null($key)) {
			throw new BoundVariableException("Can not reasign already bound variable", $key);
		}
		$this->prev = $prev;
		$this->valueVar =& $value;
		$this->keyVar =& $key
	}

	/**
	 * Bind this variable to a constant value.
	 * This value does not have to be passed by reference
	 *
	 * @param mixed $constant
	 * @return Comprehension
	 */
	public function inConst($constant)
	{
		return new ConstantContainer($this, $this->prev, $constant);
	}

	/**
	 * Bind this variable to elements in the container
	 * The container can either be an array or iterator and has to be passed by reference
	 *
	 * @param array|iterator &$container
	 * @return ArrayContainer|Comprehension
	 */
	public function inVar(&$container)
	{
		return ($container instanceof \Iterator) ?
			new IteratorContainer($this, $this->prev, $container) :
			self::is_array_or_alike($container) ?
				new ArrayContainer($this, $this->prev, $container) :
				new \Exception("A variable can only be bound to Iterators or Arrays using in");
	}

	/**
	 * Bind this variable to elements obtained from the application of a callable on other variables
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
	public function asMapping($callable,
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
		return new FunctionApplication($this, $this->prev, $callable, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j);
	}

	/**
	 * Bind this variable to elements obtained from the application of a callable on other variables
	 * Up to 10 variables may be used in the function, they must be passed by reference
	 * @param callable $callable function to use
	 * @param mixed $initial initial value for the scan function
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
	public function asScan($callable,
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
		return new Scan($this, $this->prev, $callable, $initial, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j);
	}

	/*
	 * Function used by bind context to update its value
	 * @param mixed $val
	 */
	public function updateValue($val)
	{
		$this->valueVar = $val;
	}

	/*
	 * Function used by bind context to update its value
	 * @param mixed $val
	 */
	public function updateKey($val)
	{
		$this->keyVar = $val;
	}
}

