<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

final class SchemaFactory
{

	private $queryType;

	private $mutationType;

	public function addQueryType(\GraphQL\Type\Definition\ObjectType $queryType)
	{
		$this->queryType = $queryType;
	}

	public function addMutationType(\GraphQL\Type\Definition\ObjectType $mutationType)
	{
		$this->mutationType = $mutationType;
	}

	public function build()
	{
		/**
		 * schema {
		 *     query: Query
		 *     mutation: Mutation
		 * }
		 *
		 * @see http://graphql.org/learn/schema/#the-query-and-mutation-types
		 */
		return new \GraphQL\Schema([
			'query' => $this->queryType,
			'mutation' => $this->mutationType,
		]);
	}

}
