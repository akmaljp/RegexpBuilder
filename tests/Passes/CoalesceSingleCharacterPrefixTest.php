<?php

namespace akmaljp\RegexpBuilder\Tests\Passes;

/**
* @covers akmaljp\RegexpBuilder\Passes\AbstractPass
* @covers akmaljp\RegexpBuilder\Passes\CoalesceSingleCharacterPrefix
*/
class CoalesceSingleCharacterPrefixTest extends AbstractTest
{
	public function getPassTests()
	{
		return [
			[
				[
					[1, 2],
					[3, 4]
				],
				[
					[1, 2],
					[3, 4]
				]
			],
			[
				[
					[1, 2],
					[3]
				],
				[
					[1, 2],
					[3]
				]
			],
			[
				[
					[1],
					[3]
				],
				[
					[1],
					[3]
				]
			],
			[
				[
					[1, 2],
					[2, 2],
					[3]
				],
				[
					[[[1], [2]], 2],
					[3]
				]
			],
			[
				[
					[1, 1],
					[2, 2],
					[3, 3, 3],
					[4, 2],
					[5, 3, 3]
				],
				[
					[[[2], [4]], 2],
					[[[3], [5]], 3, 3],
					[1, 1]
				]
			],
		];
	}
}