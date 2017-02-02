<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use function Adeira\Connector\GraphQL\id;
use GraphQL\Type\Definition;

final class TestQuery extends \Adeira\Connector\GraphQL\Structure\Query
{

	public function getPublicQueryName(): string
	{
		return 'test';
	}

	public function getPublicQueryDescription(): string
	{
		return 'This endpoint is intended only for testing.';
	}

	public function getQueryReturnType(): Definition\ObjectType
	{
		return new Definition\ObjectType([
			'name' => 'TestCase',
			'fields' => [
				'exception' => [
					'type' => id(),
					'resolve' => function () {
						throw new \Exception('Internal exception message with sensitive data.');
					},
				],
				'success' => [
					'type' => id(),
					'resolve' => function () {
						return '00000000-0000-0000-0000-000000000000';
					},
				],
			],
		]);
	}

	public function resolve($ancestorValue, $args, UserId $userId)
	{
		return TRUE; // pass through
	}

}
