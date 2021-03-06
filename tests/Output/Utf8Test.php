<?php

namespace akmaljp\RegexpBuilder\Tests\Output;

use InvalidArgumentException;

/**
* @covers akmaljp\RegexpBuilder\Output\BaseImplementation
* @covers akmaljp\RegexpBuilder\Output\Utf8
*/
class Utf8Test extends AbstractTest
{
	public function getOutputTests()
	{
		return [
			[ord("\n"), "\n"],
			[ord("\r"), "\r"],
			[ord("\t"), "\t"],
			[92, '\\'],
			[42, '*'],
			[102, 'f'],
			[0xC3, utf8_encode("\xC3")],
			[0x2026, "\xE2\x80\xA6"],
			[0x1F600, "\xF0\x9F\x98\x80"],
			[0x120000, new InvalidArgumentException('Value 1179648 is out of bounds (0..1114111)')],
			[0xD800, new InvalidArgumentException('Surrogate 0xD800 is not a valid UTF-8 character')],
			[0xDFFF, new InvalidArgumentException('Surrogate 0xDFFF is not a valid UTF-8 character')]
		];
	}
}