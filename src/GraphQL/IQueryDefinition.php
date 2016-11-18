<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

interface IQueryDefinition
{

	/**
	 * Returns query definitions.
	 */
	public function __invoke(): array;

}
