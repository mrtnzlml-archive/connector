<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Type;

class InputObject
{

	/**
	 * Override this method and return name of your input type.
	 *
	 * @throws \Adeira\Connector\GraphQL\Exception\OverrideException
	 */
	public function publicName(): string
	{
		throw new \Adeira\Connector\GraphQL\Exception\OverrideException(get_called_class(), __FUNCTION__);
	}

	/**
	 * Override this method and return description of your input type.
	 */
	public function publicDescription(): ?string
	{
		return NULL;
	}

	/**
	 * Override this method and return array of the \Adeira\Connector\GraphQL\Structure\Field objects.
	 *
	 * @return \Adeira\Connector\GraphQL\Type\InputValue[]
	 * @throws \Adeira\Connector\GraphQL\Exception\OverrideException
	 */
	public function fields(): array
	{
		throw new \Adeira\Connector\GraphQL\Exception\OverrideException(get_called_class(), __FUNCTION__);
	}

	/** @internal */
	public function buildStructure(): array
	{
		$config = [
			'name' => $this->publicName(),
			'description' => $this->publicDescription(),
		];

		foreach ($this->fields() as $field) {
			$structure = $field->buildStructure();
			$config['fields'][$structure['name']] = $structure; //FIXME: should be 'inputFields' (?)
		}

		return $config;
	}

}
