<?php

namespace akmaljp\RegexpBuilder\Tests\Passes;

/**
* @covers akmaljp\RegexpBuilder\Passes\AbstractPass
* @covers akmaljp\RegexpBuilder\Passes\PromoteSingleStrings
*/
class PromoteSingleStringsTest extends AbstractTest
{
	public function getPassTests()
	{
		return [
			[
				[],
				[]
			],
			[
				[
					[0, 1, 2],
					[0, 1, 3]
				],
				[
					[0, 1, 2],
					[0, 1, 3]
				],
			],
			[
				[
					[[[4, 5, 5]]]
				],
				[
					[4, 5, 5]
				],
			],
			[
				[
					[
						98,
						[
							[97, [[114], [122]]]
						]
					],
					[102, 111, 111]
				],
				[
					[
						98,
						97,
						[[114], [122]]
					],
					[102, 111, 111]
				]
			]
		];
	}
}