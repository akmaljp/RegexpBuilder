<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Input;

class Bytes extends BaseImplementation
{
	/**
	* {@inheritdoc}
	*/
	public function split($string)
	{
		if ($string === '')
		{
			return [];
		}

		return array_map('ord', str_split($string, 1));
	}
}