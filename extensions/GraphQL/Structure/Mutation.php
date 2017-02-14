<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

use Adeira\Connector\GraphQL\Context;

class Mutation
{

	public function constructTypeArrayDefinition()
	{
		$definition = [
			'name' => $this->getPublicQueryName(),
			'description' => $this->getPublicQueryDescription(),
			'type' => $this->getQueryReturnType(),
			'resolve' => [$this, 'resolve'],
		];

		$arguments = $this->defineArguments();
		if ($arguments) {
			/** @var \Adeira\Connector\GraphQL\Structure\Argument $argument */
			foreach ($arguments as $argument) {
				$fieldArray = $argument->buildArray(); //FIXME: vracet něco přádného (možná ani ne pole)
				$fieldArrayKey = key($fieldArray);
				$definition['args'][$fieldArrayKey] = $fieldArray[$fieldArrayKey];
			}
		}

		return $definition;
	}

	public function getPublicQueryName(): string
	{
		// Override this method and return name of your query.
	}

	public function getPublicQueryDescription(): string
	{
		// Override this method and return description of your query.
	}

	public function getQueryReturnType(): \GraphQL\Type\Definition\ObjectType
	{
		// Override this method and return "return type" of the query.
	}

	public function defineArguments(): ?array
	{
		return NULL;
	}

	public function resolve($ancestorValue, $args, Context $context)
	{
		//TODO
	}

}
