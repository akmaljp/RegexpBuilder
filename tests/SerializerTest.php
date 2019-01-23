<?php

namespace akmaljp\RegexpBuilder\Tests;

use PHPUnit_Framework_TestCase;
use akmaljp\RegexpBuilder\Escaper;
use akmaljp\RegexpBuilder\Input\Bytes as Input;
use akmaljp\RegexpBuilder\MetaCharacters;
use akmaljp\RegexpBuilder\Output\Bytes as Output;
use akmaljp\RegexpBuilder\Serializer;

/**
* @covers akmaljp\RegexpBuilder\Serializer
*/
class SerializerTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider getSerializerTests
	*/
	public function test($original, $expected)
	{
		$serializer = new Serializer(new Output, new MetaCharacters(new Input), new Escaper);
		$this->assertSame($expected, $serializer->serializeStrings($original, false));
	}

	public function getSerializerTests()
	{
		return [
			[
				[
					[97],
					[108],
					[109],
					[111],
					[115],
					[116]
				],
				'[almost]'
			],
			[
				[
					[],
					[97],
					[108],
					[109],
					[111],
					[115],
					[116]
				],
				'[almost]?'
			],
			[
				[
					[98, 97, [[114], [122]]],
					[102, 111, 111]
				],
				'(?:ba[rz]|foo)'
			],
			[
				[
					[102, 111, 111, [[], [108]]]
				],
				'fool?'
			],
			[
				[
					[102, 111, 111, [[], [108], [116]]]
				],
				'foo[lt]?'
			],
			[
				[
					[102, 111, 111, [[], [108], [116, 115]]]
				],
				'foo(?:l|ts)?'
			],
			[
				[
					[115, 117, 112, 101, 114, [[98, 111, 121], [109, 97, 110]]]
				],
				'super(?:boy|man)'
			],
			[
				[
					[40],
					[41]
				],
				'[()]'
			],
			[
				[
					[42],
					[43],
					[45],
					[46]
				],
				'[*+\\-.]'
			],
			[
				[
					[47],
					[63],
					[91],
					[92]
				],
				'[\\/?[\\\\]'
			],
			[
				[
					[93],
					[94],
					[123]
				],
				'[\\]\\^{]'
			],
			[
				[
					[124],
					[125]
				],
				'[|}]'
			],
			[
				[
					[97],
					[98],
					[99],
					[100],
					[101]
				],
				'[a-e]'
			],
		];
	}
}