<?php

namespace akmaljp\RegexpBuilder\Tests\Output;

use InvalidArgumentException;

/**
* @covers akmaljp\RegexpBuilder\Output\BaseImplementation
* @covers akmaljp\RegexpBuilder\Output\Bytes
*/
class BytesTest extends AbstractTest
{
	public function getOutputTests()
	{
		return [
			[92, '\\'],
			[42, '*'],
			[102, 'f'],
			[0xC3, "\xC3"],
			[0xA9, "\xA9"],
			[0xFF, "\xFF"],
			[0x100, new InvalidArgumentException('Value 256 is out of bounds (0..255)')]
		];
	}
}