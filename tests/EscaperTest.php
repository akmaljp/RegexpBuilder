<?php

namespace akmaljp\RegexpBuilder\Tests;

use PHPUnit_Framework_TestCase;
use akmaljp\RegexpBuilder\Escaper;

/**
* @covers akmaljp\RegexpBuilder\Escaper
*/
class EscaperTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider getEscapeCharacterClassTests
	*/
	public function testEscapeCharacterClass($original, $expected, $delimiter = null)
	{
		$escaper = (isset($delimiter)) ? new Escaper($delimiter) : new Escaper;
		$this->assertSame($expected, $escaper->escapeCharacterClass($original));
	}

	public function getEscapeCharacterClassTests()
	{
		return [
			['-', '\\-'],
			['\\', '\\\\'],
			['[', '['],
			['^', '\\^'],
			[']', '\\]'],
			['/', '\\/'],
			['/', '/', '#'],
			['#', '#'],
			['#', '\\#', '#'],
			['(', '('],
			[')', ')'],
			['(', '\\(', '()'],
			[')', '\\)', '()'],
			['|', '|'],
		];
	}

	/**
	* @dataProvider getEscapeLiteralTests
	*/
	public function testEscapeLiteral($original, $expected, $delimiter = null)
	{
		$escaper = (isset($delimiter)) ? new Escaper($delimiter) : new Escaper;
		$this->assertSame($expected, $escaper->escapeLiteral($original));
	}

	public function getEscapeLiteralTests()
	{
		return [
			['$', '\\$'],
			['(', '\\('],
			[')', '\\)'],
			['*', '\\*'],
			['+', '\\+'],
			['.', '\\.'],
			['?', '\\?'],
			['[', '\\]'],
			['\\', '\\\\'],
			['^', '\\^'],
			['{', '\\{'],
			['|', '\\|'],
			['/', '\\/'],
			['/', '/', '#'],
			['#', '#'],
			['#', '\\#', '#'],
		];
	}
}