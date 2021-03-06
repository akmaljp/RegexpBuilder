<?php

namespace akmaljp\RegexpBuilder\Tests;

use PHPUnit_Framework_TestCase;
use akmaljp\RegexpBuilder\Input\Utf8;
use akmaljp\RegexpBuilder\MetaCharacters;

/**
* @covers akmaljp\RegexpBuilder\MetaCharacters
*/
class MetaCharactersTest extends PHPUnit_Framework_TestCase
{
	protected function getMeta(array $map = [])
	{
		$meta = new MetaCharacters(new Utf8, $map);
		foreach ($map as $char => $expr)
		{
			$meta->add($char, $expr);
		}

		return $meta;
	}

	/**
	* @testdox Using multiple chars as meta-character throws an exception
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Meta-characters must be represented by exactly one character
	*/
	public function testMultipleCharsException()
	{
		$this->getMeta(['xx' => 'x']);
	}

	/**
	* @testdox Invalid expressions throw an exception
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid expression '+++'
	*/
	public function testInvalidExceptionException()
	{
		$this->getMeta(['x' => '+++']);
	}

	/**
	* @testdox getExpression() returns the original expression that matches the given meta value
	*/
	public function testGetExpression()
	{
		$meta    = $this->getMeta(["\0" => 'foo', "\1" => 'bar']);
		$strings = $meta->replaceMeta([[0, 1]]);

		$this->assertEquals('foo', $meta->getExpression($strings[0][0]));
		$this->assertEquals('bar', $meta->getExpression($strings[0][1]));
	}

	/**
	* @testdox getExpression() throws an exception on unknown meta values
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid meta value -1
	*/
	public function testGetExpressionException()
	{
		$this->getMeta([])->getExpression(-1);
	}

	/**
	* @testdox Meta-characters properties
	* @dataProvider getPropertiesTests
	*/
	public function testProperties($properties, $expr)
	{
		$meta    = $this->getMeta(["\0" => $expr]);
		$strings = $meta->replaceMeta([[0]]);

		$map = [
			'c' => 'isChar',
			'q' => 'isQuantifiable'
		];
		foreach ($map as $c => $methodName)
		{
			$assertMethod = (strpos($properties, $c) === false) ? 'assertFalse' : 'assertTrue';
			$msg          = $methodName . '(' . var_export($expr, true) . ')';

			$this->$assertMethod(MetaCharacters::$methodName($strings[0][0]), $msg);
		}
	}

	public function getPropertiesTests()
	{
		return [
			['cq', '\\w'      ],
			['cq', '\\d'      ],
			['cq', '\\x{2600}'],
			['cq', '\\pL'     ],
			['cq', '\\p{^L}'  ],
			['q',  '.'        ],
			['q',  '\\R'      ],
			['q',  '[0-9]'    ],
			['',   '[0-9]+'   ],
			['',   '.*'       ],
			['',   'xx'       ],
			['',   '^'        ],
			['',   '$'        ],
		];
	}
}