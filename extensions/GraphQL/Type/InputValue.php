<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Type;

class InputValue
{

	private $name;

	private $type;

	private $defaultValue;

	public function __construct(string $name, \GraphQL\Type\Definition\Type $type, $defaultValue = NULL)
	{
		$this->name = $name;
		$this->type = $type;
		$this->defaultValue = $defaultValue;
	}

	/** @internal */
	public function buildStructure(): array
	{
		return [
			'name' => $this->name,
			'type' => $this->type,
			'defaultValue' => $this->defaultValue,
			'description' => NULL, //FIXME: configurable
		];
	}

}
