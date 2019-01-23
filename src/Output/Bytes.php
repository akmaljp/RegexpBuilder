<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Output;

class Bytes extends BaseImplementation
{
	/** {@inheritdoc} */
	protected $maxValue = 255;

	/**
	* {@inheritdoc}
	*/
	protected function outputValidValue($value)
	{
		return chr($value);
	}
}