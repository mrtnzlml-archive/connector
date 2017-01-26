<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

class FieldSpecification
{

	private $name;

	private $description;

	private $type;

	private $argumentSpecifications = NULL;

	private $resolveFunction = NULL;

	public function __construct(string $name, string $description, \GraphQL\Type\Definition\Type $type)
	{
		$this->name = $name;
		$this->description = $description;
		$this->type = $type;
	}

	public function addArguments(ArgumentSpecification ...$argumentSpecifications)
	{
		foreach ($argumentSpecifications as $argumentSpecification) {
			$argArray = $argumentSpecification->buildArray();
			$argArrayKey = key($argArray);
			$this->argumentSpecifications[$argArrayKey] = $argArray[$argArrayKey];
		}
	}

	public function setResolveFunction(callable $resolveFunction)
	{
		$this->resolveFunction = $resolveFunction;
	}

	public function buildArray(): array
	{
		return [
			$this->name => [
				'type' => $this->type,
				'description' => $this->description,
				'args' => $this->argumentSpecifications,
				'resolve' => $this->resolveFunction,
			],
		];
	}

}
