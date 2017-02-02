<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

use GraphQL\Type\Definition\ResolveInfo;

final class Executor
{

	/**
	 * If a resolve function is not given, then a default resolve behavior is used
	 * which takes the property of the source object of the same name as the field
	 * and returns it as the result, or if it's a function, returns the result
	 * of calling that function while passing along args and context.
	 *
	 * @see \GraphQL\Executor\Executor::defaultFieldResolver
	 */
	public static function defaultFieldResolver($source, $args, $context, ResolveInfo $info)
	{
		$property = $source; //default pass-through resolver

		$namespace = 'GraphQL\Type\Definition'; //needed for fields introspection
		if (is_object($source) && (strpos(get_class($source), $namespace . '\\') === 0)) {
			$property = $source->{$info->fieldName};
		}

		return $property instanceof \Closure ? $property($source, $args, $context) : $property;
	}

}
