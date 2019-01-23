<?php

namespace akmaljp\RegexpBuilder\Tests\Output;

use Exception;
use PHPUnit_Framework_TestCase;

abstract class AbstractTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider getOutputTests
	*/
	public function test($original, $expected, $options = [])
	{
		$className = 'akmaljp\\RegexpBuilder\\Output\\' . preg_replace('(.*\\\\(\\w+)Test$)', '$1', get_class($this));
		$output = new $className($options);

		if ($expected instanceof Exception)
		{
			$this->setExpectedException(get_class($expected), $expected->getMessage());
		}

		$this->assertSame($expected, $output->output($original));
	}

	abstract public function getOutputTests();
}