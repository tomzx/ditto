<?php namespace Ditto\Fixtures\Classes;

class C
{
	public $a;
	public $b;

	public function __construct(A $a, B $b)
	{
		$this->a = $a;
		$this->b = $b;
	}

	public function c()
	{
		return 'c';
	}
}