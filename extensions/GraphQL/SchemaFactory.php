<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

use Adeira\Connector\GraphQL\Structure\{
	Mutation, Query
};
use GraphQL\Type\Definition\ObjectType;

final class SchemaFactory
{

	private $queryDefinitions;

	private $mutationDefinitions;

	public function addQueryDefinitions(array $queryDefinitions)
	{
		/** @var Query[] $queryDefinitions */
		$queryDefinitions = (function (Query ...$queryDefinitions) {
			return $queryDefinitions;
		})(...$queryDefinitions);

		foreach ($queryDefinitions as $definition) {
			$config = $definition->constructTypeArrayDefinition();
			$this->queryDefinitions[$config['name']] = $config;
		}
	}

	public function addMutationDefinitions(array $mutationDefinitions)
	{
		/** @var Mutation[] $mutationDefinitions */
		$mutationDefinitions = (function (Mutation ...$mutationDefinitions) {
			return $mutationDefinitions;
		})(...$mutationDefinitions);

		foreach ($mutationDefinitions as $definition) {
			$config = $definition->constructTypeArrayDefinition();
			$this->mutationDefinitions[$config['name']] = $config;
		}
	}

	public function build()
	{
		/**
		 * This is the type that will be the root of our query, and the
		 * entry point into our schema.
		 */
		$queryType = new \GraphQL\Type\Definition\ObjectType([
			'name' => 'Query',
			'fields' => $this->queryDefinitions,
		]);

		$mutationType = new ObjectType([
			'name' => 'Mutation',
			'fields' => $this->mutationDefinitions,
		]);

		/**
		 * schema {
		 *     query: Query
		 *     mutation: Mutation
		 * }
		 *
		 * @see http://graphql.org/learn/schema/#the-query-and-mutation-types
		 */
		return new \GraphQL\Schema([
			'query' => $queryType,
			'mutation' => $mutationType,
		]);
	}

}
