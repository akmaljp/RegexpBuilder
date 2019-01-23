<?php

namespace akmaljp\RegexpBuilder\Tests\Passes;

/**
* @covers akmaljp\RegexpBuilder\Passes\AbstractPass
* @covers akmaljp\RegexpBuilder\Passes\GroupSingleCharacters
*/
class GroupSingleCharactersTest extends AbstractTest
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
					[1],
					[2, 2],
					[3]
				],
				[
					[[[1], [3]]],
					[2, 2]
				]
			],
		];
	}
}