<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

use GraphQL\Type\Definition\ObjectType;

class SchemaFactory
{

	private $queryDefinitions;

	private $mutationDefinitions;

	public function addQueryDefinitions(array $queryDefinitions)
	{
		$queryDefinitions = (function (IQueryDefinition ...$queryDefinitions) {
			return $queryDefinitions;
		})(...$queryDefinitions);

		/** @var IQueryDefinition $type */
		foreach ($queryDefinitions as $type) {
			$definition = $type->__invoke();
			$this->queryDefinitions[key($definition)] = $definition[key($definition)]; //FIXME: ne jen klíč, ale všechny klíče (?)
		}
	}

	public function addMutationDefinitions(array $mutationDefinitions)
	{
		$mutationDefinitions = (function (IMutationDefinition ...$mutationDefinitions) {
			return $mutationDefinitions;
		})(...$mutationDefinitions);

		/** @var IMutationDefinition $type */
		foreach ($mutationDefinitions as $type) {
			$definition = $type->__invoke();
			$this->mutationDefinitions[key($definition)] = $definition[key($definition)]; //FIXME: ne jen klíč, ale všechny klíče (?)
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
