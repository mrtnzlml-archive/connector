<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Type;

class InputValue
{

	private $name;

	private $type;

	public function __construct(string $name, \GraphQL\Type\Definition\Type $type)
	{
		$this->name = $name;
		$this->type = $type;
	}

	/** @internal */
	public function _buildStructure(): array
	{
		return [
			'name' => $this->name,
			'type' => $this->type,
			'defaultValue' => NULL, //FIXME: configurable
			'description' => NULL, //FIXME: configurable
		];
	}

}
