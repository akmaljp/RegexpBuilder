<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Passes;

interface PassInterface
{
	/**
	* Run this pass
	*
	* @param  array[] $strings Original strings
	* @return array[]          Modified strings
	*/
	public function run(array $strings);
}