<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

final class TypeSpecification
{

	private $name;

	private $description;

	private $fields = [];

	public function __construct(string $name, string $description)
	{
		$this->name = $name;
		$this->description = $description;
	}

	public function addField(FieldSpecification $fieldSpecification)
	{
		$fieldArray = $fieldSpecification->buildArray();
		$fieldArrayKey = key($fieldArray);
		$this->fields[$fieldArrayKey] = $fieldArray[$fieldArrayKey];
	}

	public function buildArray(): array
	{
		return [
			'name' => $this->name,
			'description' => $this->description,
			'fields' => $this->fields,
		];
	}

}
