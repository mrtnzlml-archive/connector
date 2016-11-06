<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

/**
 * The most basic components of a GraphQL schema are object types, which just represent a kind of object you can fetch
 * from your service, and what fields it has. In the GraphQL schema language, we might represent it like this:
 *
 * type Character {
 *     name: String!
 *     appearsIn: [Episode]!
 * }
 *
 * Object definition options:
 * > name (string) - required
 * > fields (array) - required
 * > description (string)
 * > interfaces (array | callable)
 * > isTypeOf (callable)
 *
 * @see http://graphql.org/learn/schema/#object-types-and-fields
 */
interface IType
{

	public function getTypeDefinition(): \GraphQL\Type\Definition\ObjectType;

	public function getPublicTypeDefinition(): array;

}
