<?php namespace Ditto\Fixtures\Classes;

class B
{
	public $a;

	public function __construct(A $a)
	{
		$this->a = $a;
	}

	public function a()
	{
		return $this->a;
	}

	public function b()
	{
		return 'b';
	}
}