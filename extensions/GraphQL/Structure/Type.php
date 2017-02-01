<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

class Type
{

	//TODO: interfaces, isTypeOf, resolveField

	public function constructTypeArrayDefinition()
	{
		$config = ['name' => $this->getPublicTypeName()];
		$description = $this->getPublicTypeDescription();
		if($description !== NULL) {
			$config['description'] = $description;
		}

		/** @var \Adeira\Connector\GraphQL\Structure\Field $field */
		foreach ($this->defineFields() as $field) {
			$fieldArray = $field->buildArray();
			$fieldArrayKey = key($fieldArray);
			$config['fields'][$fieldArrayKey] = $fieldArray[$fieldArrayKey];
		}

		return $config;
	}

	public function getPublicTypeName(): string
	{
		// Override this method and return name of your type.
	}

	public function getPublicTypeDescription(): string
	{
		// Override this method and return description of your type.
	}

	public function defineFields(): array
	{
		// Override this method and return array of the \Adeira\Connector\GraphQL\Structure\Field objects.
	}

}
