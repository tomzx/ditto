<?php namespace Ditto;

use Ditto\Ditto as d;

class DittoTest extends \PHPUnit_Framework_TestCase {
	public function testItIsInitializable()
	{
		$this->assertInstanceOf('Ditto\Ditto', d::make('stdClass'));
	}

	public function testItCanInstantiateArgumentlessClasses()
	{
		$this->assertInstanceOf('Ditto\Ditto', d::make('Ditto\Fixtures\Classes\A'));
	}

	public function testItCanInstantiateClassesWithArguments()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\C');
		$this->assertInstanceOf('Ditto\Ditto', $ditto);
		$this->assertInstanceOf('Ditto\Fixtures\Classes\A', $ditto->a);
		$this->assertInstanceOf('Ditto\Fixtures\Classes\B', $ditto->b);
		$this->assertInstanceOf('Ditto\Fixtures\Classes\A', $ditto->b->a);
	}

	public function testItCanSetValuesOnObject()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\C');
		$this->assertInstanceOf('Ditto\Fixtures\Classes\A', $ditto->a);
		$ditto->a = 'test';
		$this->assertNotInstanceOf('Ditto\Fixtures\Classes\A', $ditto->a);
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
		$ditto = d::make('Ditto\Fixtures\Classes\A');
		$ditto->shouldBeAwesome();
	}

	public function testItTesthasXMethodsWhenShouldHaveIsCalled()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\A');
		$ditto->shouldHaveJabberwocky();
	}

	public function testItShouldAssertSame()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\A');
		$ditto->a()->shouldReturn('a');
		$ditto->a()->shouldBe('a');
		$ditto->a()->shouldEqual('a');
		$ditto->a()->shouldBeEqualTo('a');
	}

	public function testItShouldAssertEquals()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\A');
		$ditto->a()->shouldBeLike('a');
	}

	public function testItShouldAssertInstanceOf()
	{
		$ditto = d::make('Ditto\Fixtures\Classes\B');
		$ditto->a()->shouldHaveType('Ditto\Fixtures\Classes\A');
	}
}