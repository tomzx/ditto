<?php namespace Ditto;

use Illuminate\Container\Container;

class Ditto
{
	protected $object;

	protected $last_result;

	protected static $container;

	protected $test_keywords = [
		'shouldReturn' => 'assertSame',
		'shouldBe' => 'assertSame',
		'shouldEqual' => 'assertSame',
		'shouldBeEqualTo' => 'assertSame',
		'shouldBeLike' => 'assertEquals',
		'shouldHaveType' => 'assertInstanceOf',
		'shouldReturnAnInstanceOf' => 'assertInstanceOf',
		'shouldBeAnInstance' => 'assertInstanceOf',
		'shouldImplement' => 'assertInstanceOf',
	];

	private function __construct($object)
	{
		$this->object = $object;
		$this->last_result = $object;
	}

	public static function make($instance)
	{
		self::initializeContainer();
		if (gettype($instance) === 'string') {
			// Check if we can make it
			if (class_exists($instance)) {
				$instance = self::$container->make($instance);
			}
		}

		return new self($instance);
	}

	protected static function initializeContainer()
	{
		if (self::$container === null) {
			self::$container = new Container();
		}
	}

	public function __call($method, array $arguments = [])
	{
		if (strpos($method, 'should') === 0) {
			if (array_key_exists($method, $this->test_keywords)) {
				$assert = $this->test_keywords[$method];
				$this->$assert($arguments);
				$this->last_result = $this->object;
				return $this;
			} else if (strpos($method, 'shouldBe') === 0) {
				$method = 'is'.substr($method, strlen('shouldBe'));
				// TODO: Check if method exists
				\PHPUnit_Framework_Assert::assertTrue($this->object->$method());
			} else 	if (strpos($method, 'shouldHave') === 0) {
				$method = 'has'.substr($method, strlen('shouldHave'));
				// TODO: Check if method exists
				\PHPUnit_Framework_Assert::assertTrue($this->object->$method());
			}
		}

		$this->last_result = call_user_func_array(array($this->last_result, $method), $arguments);

		return $this;
	}

	public function __get($key)
	{
		// TODO: Check if property exists
		return $this->last_result->$key;
	}

	public function __set($key, $value)
	{
		$this->last_result->$key = $value;
	}

	protected function assertSame($arguments)
	{
		\PHPUnit_Framework_Assert::assertSame($arguments[0], $this->last_result);
	}

	protected function assertEquals($arguments)
	{
		\PHPUnit_Framework_Assert::assertEquals($arguments[0], $this->last_result);
	}

	protected function assertInstanceOf($arguments)
	{
		\PHPUnit_Framework_Assert::assertInstanceOf($arguments[0], $this->last_result);
	}
}