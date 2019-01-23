<?php

namespace akmaljp\RegexpBuilder\Tests;

use PHPUnit_Framework_TestCase;
use akmaljp\RegexpBuilder\Runner;

/**
* @covers akmaljp\RegexpBuilder\Runner
*/
class RunnerTest extends PHPUnit_Framework_TestCase
{
	public function testRun()
	{
		$original = [[1, 2], [1, 3]];
		$expected = [[1, [[2], [3]]]];

		$mock = $this->getMockBuilder('akmaljp\RegexpBuilder\Passes\PassInterface')->getMock();
		$mock->expects($this->once())
		     ->method('run')
		     ->with($original)
		     ->will($this->returnValue($expected));

		$runner = new Runner;
		$runner->addPass($mock);

		$this->assertSame($expected, $runner->run($original));
	}
}