<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder\Input;

abstract class BaseImplementation implements InputInterface
{
	/**
	* {@inheritdoc}
	*/
	public function __construct(array $options = [])
	{
	}

	/**
	* {@inheritdoc}
	*/
	abstract public function split($string);
}