<?php
namespace Comprehension\Component;
/*
 * Sets a reference to an array as a context for a bound variable. When the values of the reference are updates so is
 * the context
 */
class ArrayContainer extends Container
{
	/**
	 * Creates the array context for the assinment from an array passed by reference, possibly a previously bound
	 * variable.
	 * @param Assignment $assinment
	 * @param Comprehension $prev previously constructed comprehension
	 * @param &array $content
	 */
	public function __construct(Comprehension $prev, Assignment $assignment, \ArrayAccess $context)
	{
		parent::__construct($prev, $assignment, $context);
	}
	/**
	 * Binds the variable to an array located at the key in the supplied content.
	 * The value at the key must be an other array or an exception will be thrown at runtime
	 *
	 * @param $ind mixed key for array we wish to iteratate over
	 */
	public function atVar(&$ind)
	{
		return $this->at(new ContainerAtVar($this->inner(), $ind));
	}

	/**
	 * Binds the variable to an array located at the key in the supplied content.
	 * The value at the key must be an other array or an exception will be thrown at runtime
	 *
	 * @param $ind mixed key for array we wish to iteratate over
	 */
	public function atConst($ind)
	{
		return $this->at(new ContainerAtConst($this->inner(), $ind));
	}

	/**
	 * create the new Container
	 *
	 * @return Container
	 */
	private function at($atCont)
	{
		if (($atCont->container() instanceOf ArrayIterator) ||
			($atCont->container() instanceOf \ArrayIterator)) {
			$iterator = new atArrayIterator($atCont));
		} else {
			$iterator = new atIteratorIterator($atCont));
		}
		$cont = self::container($iterator, $this->assignment(), $this->prev());
		$this->unsetAll();
		return $cont;
	}
}
	
