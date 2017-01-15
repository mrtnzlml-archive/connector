<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Structure;

class Argument
{

	private function __construct()
	{
	}

	public static function create(\GraphQL\Type\Definition\Type $type, string $description = NULL): array
	{
		return [
			'type' => $type,
			'description' => $description,
		];
	}

}
