<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

class Query
{

	public function constructTypeArrayDefinition()
	{
		$definition = [
			'name' => $this->getPublicQueryName(),
			'type' => $this->getQueryReturnType(),
			'resolve' => [$this, 'resolve'],
		];

		/** @var \Adeira\Connector\GraphQL\Structure\Argument $argument */
		foreach ($this->defineArguments() as $argument) {
			$fieldArray = $argument->buildArray(); //FIXME: vracet něco přádného (možná ani ne pole)
			$fieldArrayKey = key($fieldArray);
			$definition['args'][$fieldArrayKey] = $fieldArray[$fieldArrayKey];
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
		//TODO
	}

	public function resolve($ancestorValue, $args, UserId $userId)
	{
		//TODO
	}

}
