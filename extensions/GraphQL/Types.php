<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL {

	use Adeira\Connector\GraphQL\Structure\Type;
	use GraphQL\Type\Definition as D;

	// Required internal types:

	function id(): D\NonNull
	{
		return required(D\Type::id());
	}

	function int(): D\NonNull
	{
		return required(D\Type::int());
	}

	function string(): D\NonNull
	{
		return required(D\Type::string());
	}

	// Nullable internal types:

	function nullableInt(): D\Type
	{
		return D\Type::getNullableType(int());
	}

	function nullableString(): D\Type
	{
		return D\Type::getNullableType(string());
	}

	// Additional functions:

	function required($type): D\NonNull
	{
		return D\Type::nonNull($type);
	}

	function listOf(Type $type): D\ListOfType
	{
		return D\Type::listOf(type($type));
	}

	function type(Type $type): D\ObjectType
	{
		return TypeRegistry::constructObjectType($type);
	}

	class TypeRegistry
	{

		private static $registry = [];

		public static function constructObjectType(Type $type): D\ObjectType
		{
			$definition = $type->constructTypeArrayDefinition();
			if (!isset(self::$registry[$definition['name']])) {
				self::$registry[$definition['name']] = new D\ObjectType($definition);
			}
			return self::$registry[$definition['name']];
		}

	}
}
