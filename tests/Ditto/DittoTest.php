<?php namespace Ditto\Test;

use Ditto\Ditto as d;
use Ditto\Ditto;
use Ditto\Test\Fixtures\Classes\A;
use Ditto\Test\Fixtures\Classes\B;
use Ditto\Test\Fixtures\Classes\C;
use PHPUnit\Framework\TestCase;
use stdClass;

class DittoTest extends TestCase {
	public function testItIsInitializable()
	{
		$this->assertInstanceOf(Ditto::class, d::make(stdClass::class));
	}

	public function testItCanInstantiateArgumentlessClasses()
	{
		$this->assertInstanceOf(Ditto::class, d::make(A::class));
	}

	public function testItCanInstantiateClassesWithArguments()
	{
		$ditto = d::make(C::class);
		$this->assertInstanceOf(Ditto::class, $ditto);
		$this->assertInstanceOf(A::class, $ditto->a);
		$this->assertInstanceOf(B::class, $ditto->b);
		$this->assertInstanceOf(A::class, $ditto->b->a);
	}

	public function testItCanSetValuesOnObject()
	{
		$ditto = d::make(C::class);
		$this->assertInstanceOf(A::class, $ditto->a);
		$ditto->a = 'test';
		$this->assertNotInstanceOf(A::class, $ditto->a);
	}

	public function testItWorksOnIntrinsicValues()
	{
		$ditto = d::make(15);
		$ditto->shouldBe(15);

		$ditto = d::make('this is a test');
		$ditto->shouldBeLike('this is a test');
	}

	public function testItTestisXMethodsWhenShouldBeIsCalled()
	{
		$ditto = d::make(A::class);
		$ditto->shouldBeAwesome();
	}

	public function testItTesthasXMethodsWhenShouldHaveIsCalled()
	{
		$ditto = d::make(A::class);
		$ditto->shouldHaveJabberwocky();
	}

	public function testItShouldAssertSame()
	{
		$ditto = d::make(A::class);
		$ditto->a()->shouldReturn('a');
		$ditto->a()->shouldBe('a');
		$ditto->a()->shouldEqual('a');
		$ditto->a()->shouldBeEqualTo('a');
	}

	public function testItShouldAssertEquals()
	{
		$ditto = d::make(A::class);
		$ditto->a()->shouldBeLike('a');
	}

	public function testItShouldAssertInstanceOf()
	{
		$ditto = d::make(B::class);
		$ditto->a()->shouldHaveType(A::class);
	}

	public function testItShouldDecapsulateArgumentsIfTheyAreDittoObjects()
	{
		$a = new \Ditto\Test\Fixtures\Classes\A();
		$ditto_a = d::make($a);
		$ditto_b = d::make($ditto_a);

		$this->assertInstanceOf(Ditto::class, $ditto_a);
		$this->assertInstanceOf(Ditto::class, $ditto_b);
		$this->assertSame($a, $ditto_a->getObject());
		$this->assertSame($ditto_a, $ditto_b->getObject());
		$ditto_a->getThis()->shouldReturn($a);
		$ditto_b->getThis()->shouldReturn($a);
	}
}
