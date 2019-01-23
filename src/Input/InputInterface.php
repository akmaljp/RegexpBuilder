<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Input;

interface InputInterface
{
	/**
	* @param array $options
	*/
	public function __construct(array $options = []);

	/**
	* Split given string into a list of values
	*
	* @param  string    $string
	* @return integer[]
	*/
	public function split($string);
}