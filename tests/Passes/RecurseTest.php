<?php

namespace akmaljp\RegexpBuilder\Tests\Passes;

use PHPUnit_Framework_TestCase;
use akmaljp\RegexpBuilder\Passes\Recurse;

/**
* @covers akmaljp\RegexpBuilder\Passes\AbstractPass
* @covers akmaljp\RegexpBuilder\Passes\Recurse
*/
class RecurseTest extends PHPUnit_Framework_TestCase
{
	public function test()
	{
		$mock = $this->getMockBuilder('akmaljp\\RegexpBuilder\\Runner')
		             ->disableOriginalConstructor()
		             ->getMock();

		$mock->expects($this->at(0))
		     ->method('run')
		     ->with([0, 1, 2])
		     ->will($this->returnValue([0, 1]));

		$mock->expects($this->at(1))
		     ->method('run')
		     ->with([1, 2, 3])
		     ->will($this->returnValue([2, 3]));

		$pass = new Recurse($mock);
		$this->assertSame(
			[[[0, 1], [2, 3]]],
			$pass->run([[[0, 1, 2], [1, 2, 3]]])
		);
	}
}