<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

/**
 * An Interface is an abstract type that includes a certain set of fields that a type must include to implement the
 * interface. For example, you could have an interface 'Character' that represents any character in the Star Wars
 * trilogy:
 *
 * interface Character {
 *     id: ID!
 *     name: String!
 *     friends: [Character]
 *     appearsIn: [Episode]!
 * }
 *
 * This means that any type that implements 'Character' needs to have these exact fields, with these arguments and
 * return types.
 *
 * Interface definition options:
 * > name (string) - required
 * > fields (array) - required
 * > description (string)
 * > resolveType (callable)
 *
 * @see http://graphql.org/learn/schema/#enumeration-types
 */
interface IInterface
{

	public function getInterfaceDefinition(): \GraphQL\Type\Definition\InterfaceType;

}
