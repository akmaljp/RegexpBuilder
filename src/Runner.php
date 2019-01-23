<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder;

use akmaljp\RegexpBuilder\Passes\PassInterface;

class Runner
{
	/**
	* @var PassInterface[]
	*/
	protected $passes = [];

	/**
	* Add a pass to the list
	*
	* @param  PassInterface $pass
	* @return void
	*/
	public function addPass(PassInterface $pass)
	{
		$this->passes[] = $pass;
	}

	/**
	* Run all passes on the list of strings
	*
	* @param  array[] $strings
	* @return array[]
	*/
	public function run(array $strings)
	{
		foreach ($this->passes as $pass)
		{
			$strings = $pass->run($strings);
		}

		return $strings;
	}
}