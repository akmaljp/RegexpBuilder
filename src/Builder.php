<?php

/**
* @package   akmaljp\RegexpBuilder
* @copyright Copyright (c) 2016-2018 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\RegexpBuilder;

use akmaljp\RegexpBuilder\Input\InputInterface;
use akmaljp\RegexpBuilder\Output\OutputInterface;
use akmaljp\RegexpBuilder\Passes\CoalesceOptionalStrings;
use akmaljp\RegexpBuilder\Passes\CoalesceSingleCharacterPrefix;
use akmaljp\RegexpBuilder\Passes\GroupSingleCharacters;
use akmaljp\RegexpBuilder\Passes\MergePrefix;
use akmaljp\RegexpBuilder\Passes\MergeSuffix;
use akmaljp\RegexpBuilder\Passes\PromoteSingleStrings;
use akmaljp\RegexpBuilder\Passes\Recurse;

class Builder
{
	/**
	* @var InputInterface
	*/
	protected $input;

	/**
	* @var MetaCharacters
	*/
	protected $meta;

	/**
	* @var Runner
	*/
	protected $runner;

	/**
	* @var Serializer
	*/
	protected $serializer;

	/**
	* @param array $config
	*/
	public function __construct(array $config = [])
	{
		$config += [
			'delimiter'     => '/',
			'input'         => 'Bytes',
			'inputOptions'  => [],
			'meta'          => [],
			'output'        => 'Bytes',
			'outputOptions' => []
		];

		$this->setInput($config['input'], $config['inputOptions']);
		$this->setMeta($config['meta']);
		$this->setSerializer($config['output'], $config['outputOptions'], $config['delimiter']);
		$this->setRunner();
	}

	/**
	* Build and return a regular expression that matches all of the given strings
	*
	* @param  string[] $strings Literal strings to be matched
	* @return string            Regular expression (without delimiters)
	*/
	public function build(array $strings)
	{
		$strings = array_unique($strings);
		if ($this->isEmpty($strings))
		{
			return '';
		}

		$strings = $this->splitStrings($strings);
		usort($strings, __CLASS__ . '::compareStrings');
		$strings = $this->meta->replaceMeta($strings);
		$strings = $this->runner->run($strings);

		return $this->serializer->serializeStrings($strings);
	}

	/**
	* Compare two split strings
	*
	* Will sort strings in ascending order
	*
	* @param  integer[] $a
	* @param  integer[] $b
	* @return integer
	*/
	protected function compareStrings(array $a, array $b)
	{
		$i   = -1;
		$cnt = min(count($a), count($b));
		while (++$i < $cnt)
		{
			if ($a[$i] !== $b[$i])
			{
				return $a[$i] - $b[$i];
			}
		}

		return count($a) - count($b);
	}

	/**
	* Test whether the list of strings is empty
	*
	* @param  string[] $strings
	* @return bool
	*/
	protected function isEmpty(array $strings)
	{
		return (empty($strings) || $strings === ['']);
	}

	/**
	* Set the InputInterface instance in $this->input
	*
	* @param  string $inputType
	* @param  array  $inputOptions
	* @return void
	*/
	protected function setInput($inputType, array $inputOptions)
	{
		$className   = __NAMESPACE__ . '\\Input\\' . $inputType;
		$this->input = new $className($inputOptions);
	}

	/**
	* Set the MetaCharacters instance in $this->meta
	*
	* @param  array $map
	* @return void
	*/
	protected function setMeta(array $map)
	{
		$this->meta = new MetaCharacters($this->input);
		foreach ($map as $char => $expr)
		{
			$this->meta->add($char, $expr);
		}
	}

	/**
	* Set the Runner instance $in this->runner
	*
	* @return void
	*/
	protected function setRunner()
	{
		$this->runner = new Runner;
		$this->runner->addPass(new MergePrefix);
		$this->runner->addPass(new GroupSingleCharacters);
		$this->runner->addPass(new Recurse($this->runner));
		$this->runner->addPass(new PromoteSingleStrings);
		$this->runner->addPass(new CoalesceOptionalStrings);
		$this->runner->addPass(new MergeSuffix);
		$this->runner->addPass(new CoalesceSingleCharacterPrefix);
	}

	/**
	* Set the Serializer instance in $this->serializer
	*
	* @param  string $outputType
	* @param  array  $outputOptions
	* @param  string $delimiter
	* @return void
	*/
	protected function setSerializer($outputType, array $outputOptions, $delimiter)
	{
		$className = __NAMESPACE__ . '\\Output\\' . $outputType;
		$output    = new $className($outputOptions);
		$escaper   = new Escaper($delimiter);

		$this->serializer = new Serializer($output, $this->meta, $escaper);
	}

	/**
	* Split all given strings by character
	*
	* @param  string[] $strings List of strings
	* @return array[]           List of arrays
	*/
	protected function splitStrings(array $strings)
	{
		return array_map([$this->input, 'split'], $strings);
	}
}