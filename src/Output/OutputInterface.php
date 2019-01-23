<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Output;

interface OutputInterface
{
	/**
	* Serialize a value into a character
	*
	* @param  integer $value
	* @return string
	*/
	public function output($value);
}