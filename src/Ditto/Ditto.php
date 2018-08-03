<?php namespace Ditto;

use Illuminate\Container\Container;
use PHPUnit\Framework\Assert;

/**
 * @method void shouldReturn(mixed $expected)
 * @method void shouldBe(mixed $expected)
 * @method void shouldEqual(mixed $expected)
 * @method void shouldBeEqualTo(mixed $expected)
 * @method void shouldBeLike(mixed $expected)
 * @method void shouldHaveType(mixed $expected)
 * @method void shouldReturnAnInstanceOf(mixed $expected)
 * @method void shouldBeAnInstance(mixed $expected)
 * @method void shouldImplement(mixed $expected)
 */
class Ditto
{
	/**
	 * \Illuminate\Container\Container
	 */
	protected static $container;

	/**
	 * @var mixed
	 */
	protected $object;

	/**
	 * @var array
	 */
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

	/**
	 * @param mixed $object
	 */
	protected function __construct($object)
	{
		$this->object = $object;
	}

	/**
	 * @return mixed
	 */
	public function getObject()
	{
		return $this->object;
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return isset($this->object->$key);
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->object->$key;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key, $value)
	{
		$this->object->$key = $value;
	}

	/**
	 * @param string $key
	 */
	public function __unset($key)
	{
		unset($this->object->$key);
	}

	/**
	 * @param string $method
	 * @param array $arguments
	 * @return $this|\Ditto\Ditto
	 */
	public function __call($method, array $arguments = [])
	{
		if (strpos($method, 'should') !== 0) {
			$result = call_user_func_array([$this->object, $method], $arguments);
			return static::capsulate($result);
		}

		if (array_key_exists($method, $this->test_keywords)) {
			$assert = $this->test_keywords[$method];
			$this->$assert($arguments);
		} else if (strpos($method, 'shouldBe') === 0) {
			$method = 'is'.substr($method, strlen('shouldBe'));
			// TODO: Check if method exists
			Assert::assertTrue($this->object->$method());
		} else if (strpos($method, 'shouldHave') === 0) {
			$method = 'has'.substr($method, strlen('shouldHave'));
			// TODO: Check if method exists
			Assert::assertTrue($this->object->$method());
		}

		return $this;
	}

	/**
	 * @param array $arguments
	 */
	protected function assertSame(array $arguments)
	{
		Assert::assertSame($this->decapsulate($arguments[0]), $this->decapsulate($this->object));
	}

	/**
	 * @param array $arguments
	 */
	protected function assertEquals(array $arguments)
	{
		Assert::assertEquals($this->decapsulate($arguments[0]), $this->decapsulate($this->object));
	}

	/**
	 * @param array $arguments
	 */
	protected function assertInstanceOf(array $arguments)
	{
		Assert::assertInstanceOf($this->decapsulate($arguments[0]), $this->decapsulate($this->object));
	}

	/**
	 * @param string|object $instance
	 * @return \Ditto\Ditto
	 */
	public static function make($instance)
	{
		// Check if we can make it
		if (is_string($instance) && class_exists($instance)) {
			$instance = static::getContainer()->make($instance);
		}

		return static::capsulate($instance);
	}

	/**
	 * @return \Illuminate\Container\Container
	 */
	protected static function getContainer()
	{
		if (static::$container === null) {
			static::$container = static::makeContainer();
		}

		return static::$container;
	}

	/**
	 * @return \Illuminate\Container\Container
	 */
	protected static function makeContainer()
	{
		return new Container();
	}

	/**
	 * @param mixed $object
	 * @return \Ditto\Ditto
	 */
	protected static function capsulate($object)
	{
		return new static($object);
	}

	/**
	 * @param mixed $object
	 * @return mixed
	 */
	protected static function decapsulate($object)
	{
		if (! $object instanceof self) {
			return $object;
		}

		return static::decapsulate($object->getObject());
	}
}
