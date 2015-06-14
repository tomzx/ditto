# Ditto

[![License](https://poser.pugx.org/tomzx/ditto/license.svg)](https://packagist.org/packages/tomzx/ditto)
[![Latest Stable Version](https://poser.pugx.org/tomzx/ditto/v/stable.svg)](https://packagist.org/packages/tomzx/ditto)
[![Latest Unstable Version](https://poser.pugx.org/tomzx/ditto/v/unstable.svg)](https://packagist.org/packages/tomzx/ditto)
[![Build Status](https://img.shields.io/travis/tomzx/ditto.svg)](https://travis-ci.org/tomzx/ditto)
[![Code Quality](https://img.shields.io/scrutinizer/g/tomzx/ditto.svg)](https://scrutinizer-ci.com/g/tomzx/ditto/code-structure)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tomzx/ditto.svg)](https://scrutinizer-ci.com/g/tomzx/ditto)
[![Total Downloads](https://img.shields.io/packagist/dt/tomzx/ditto.svg)](https://packagist.org/packages/tomzx/ditto)

## What is Ditto?

Ditto is a simple wrapper around PHPUnit assertions which allows developers to use a syntax similar to the one provided by [phpspec matchers](http://www.phpspec.net/docs/introduction.html#matchers). With it, you can replace your calls to `assertSame`, `assertEquals` and `assertInstanceOf`.

## Usage

```php
use Ditto\Ditto as d;

$ditto = d::make('SomeClass');
$ditto->someMethod()->shouldReturn('some value');

// ===
$ditto->someMethod()->shouldReturn('some value');
$ditto->someMethod()->shouldBe('some value');
$ditto->someMethod()->shouldEqual('some value');
$ditto->someMethod()->shouldBeEqualTo('some value');

// ==
$ditto->someMethod()->shouldBeLike('some value');

// instanceof
$ditto->someMethod()->shouldHaveType('SomeType');
$ditto->someMethod()->shouldReturnAnInstanceOf('SomeType');
$ditto->someMethod()->shouldBeAnInstance('SomeType');
$ditto->someMethod()->shouldImplement('SomeType');

// It also works on intrinsic values
$ditto = d::make('this is nice');
$ditto->shouldReturn('this is nice');

$ditto = d::make(15);
$ditto->shouldBe(15);
```

## Contributing to Ditto

**All issues and pull requests should be filed on the [tomzx/ditto](http://github.com/tomzx/ditto) repository.**

## License

The code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). See [LICENSE](LICENSE).
