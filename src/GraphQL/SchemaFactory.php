<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

class SchemaFactory
{

	private $types;

	public function addTypes(array $types)
	{
		$types = (function (IType ...$types) {
			return $types;
		})(...$types);

		/** @var IType $type */
		foreach ($types as $type) {
			$definition = $type->getPublicTypeDefinition();
			$this->types[key($definition)] = $definition[key($definition)]; //FIXME: ne jen klíč, ale všechny klíče (?)
		}
	}

	public function build()
	{
		/**
		 * This is the type that will be the root of our query, and the
		 * entry point into our schema.
		 *
		 * type Query {
		 *     device(id: String!): InboundSource
		 * }
		 */
		$queryType = new \GraphQL\Type\Definition\ObjectType([
			'name' => 'Query',
			'fields' => $this->types,
		]);

//		/**
//		 * input DeviceInput {
//		 * }
//		 */
//		$mutationType = new ObjectType([
//			'name' => 'Mutation',
//			'fields' => [
//				'device' => [
//					'type' => $deviceType,
//					'args' => [
//						'id' => [
//							'name' => 'id',
//							'description' => 'id of the device',
//							'type' => Type::nonNull(Type::string()),
//						],
//					],
//					'resolve' => function ($root, $args) {
//						\Tracy\Debugger::log($args);
//					},
//				],
//			],
//		]);

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
//			'mutation' => $mutationType,
		]);
	}

}
