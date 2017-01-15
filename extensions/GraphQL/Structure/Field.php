<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

class Field
{

	private function __construct()
	{
	}

	/**
	 * Resolve: callback($ancestorValue, $args, $context, ResolveInfo $info) => $fieldValue
	 */
	public static function create(
		\GraphQL\Type\Definition\Type $type,
		callable $resolveFunction,
		array $args = NULL,
		string $description = NULL
	): array {
		return [
			'type' => $type,
			'resolve' => $resolveFunction,
			'args' => $args,
			'description' => $description,
		];
	}

}
