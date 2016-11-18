<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

interface IMutationDefinition
{

	/**
	 * Returns mutation definitions.
	 */
	public function __invoke(): array;

}
