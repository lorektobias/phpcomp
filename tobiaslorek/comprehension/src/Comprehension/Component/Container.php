<?php
namespace Comprehension\Component;
/*
 * Creates a context for a bound variable
 */
abstract class Container extends Comprehension
{
	private $assignment;
	private $primary_context;
	private $secondary_context;
	private $prev;
	private $primary;
	private $secondary;
	public function __construct(Comprehension $prev, Assignment $assignment, &$context)
	{
		if (is_null($context)) {
			throw new BoundVariableException("Can not bind variable to a free (null) context", $assignment, $context);
		}
		parent::__construct($prev);
		$this->prev = $prev;
		$this->primary =& $context;
		$this->primary_context = $this->sanitize_context($this->primary);
		$this->assignment = $assignment;
		$this->push();
	}

	public function sanatize()
	{
		$this->primary_context = $this->sanitize_context($this->primary);
		if (!is_null($this->secondary)) {
			$this->secondary_context = $this->sanitize_context($this->secondary);
		}
	}

	protected function inner()
	{
		return $this->context;
	}

	/**
	 * get the previous Comprehension
	 *
	 * @return Comprehension
	 */
	protected function prev()
	{
		return $this->prev;
	}

	/**
	 * get the current assignemtn
	 *
	 * @return Assignment
	 */
	protected function assignment()
	{
		return $this->assignment;
	}

	/**
	 * unsets all variables
	 *
	 * @return void
	 */
	protected function unsetAssignment()
	{
		unset($this->assignment);
	}

	protected function pushToAssignment()
	{
		if ($this->assignment) {
			$this->assignment->updateValue($this->currentValue());
			$this->assignment->updateKey($this->currentKey());
		}
	}

	protected function moveCurrent()
	{
		$this->primary_context->next();
		return $this->primary_context->valid() !== false;
	}

	abstract protected function rewindCurrent()
	{
		$this->primary_context->rewind();
	}

	protected function currentValue()
	{
		return $this->primary_context->current();
	}

	protected function currentKey()
	{
		return $this->primary_context->key();
	}

	protected function sanitize_context($context)
	{
		if ($context instanceOf \Iterator) {
			$sanitized = $context;
		} elseif (is_array($context)) {
			$sanitized = new ArrayIterator($context);
		} elseif (is_string($context)) {
			$sanitized = new StringIterator($context);
		} else {
			throw new NotAContainerException(
				"Value at index must be a container, either an array, iterator or string",
				$context
			);
		}
		return $sanitized;
	}

	public static function container(&$context, $assignment, $prev)
	{
		if (self::is_array_or_alike($container)) {
			return new ArrayContainer($context, $assignment, $prev);
		} else {
			return new IteratorContainer($context, $assignment, $prev);
		}
	}

	public function or(&$other)
	{
		$this->setSecondary($other);
		return new Container($this, $this->assignment(), new PlusIterator($this->primary_context, $this->secondary_context);
	}

	public function pick(&$other)
	{
		$this->setSecondary($other);
		return new Container($this, $this->assignment(), new ExpIterator($this->primary_context, $this->secondary_context);
	}

	public function filterBy($func)
	{
		return new Container($this, $this->assignment(), new FilterIterator($this->primary_context, $pred);
	}

	public function groupBy($other)
	{
		return new Container($this, $this->assignment(), new GroupingIterator($this->primary_context, $func);
	}

	private function setSecondary(&$secondary)
	{
		$this->secondary =& $secondary_context;
		$this->secondary_context = $this->sanitize_context($this->secondary);
	}
}

