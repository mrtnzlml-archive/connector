<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

class ArgumentSpecification
{

	private $name;

	private $description;

	private $type;

	public function __construct(string $name, string $description, \GraphQL\Type\Definition\Type $type)
	{
		$this->name = $name;
		$this->description = $description;
		$this->type = $type;
	}

	public function buildArray(): array
	{
		return [
			$this->name => [
				'type' => $this->type,
				'description' => $this->description,
			],
		];
	}

}
