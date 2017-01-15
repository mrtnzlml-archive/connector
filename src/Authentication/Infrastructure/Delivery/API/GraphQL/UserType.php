<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\User;
use GraphQL\Type\Definition;

class UserType extends Definition\ObjectType
{

	public function __construct()
	{
		parent::__construct([
			'name' => 'User',
			'description' => 'User entity.',
			'fields' => [
				'id' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'The ID of the User.',
					'resolve' => function (User $user, $args, $context) {
						return $user->id();
					},
				],
				'username' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'Username of the user.',
					'resolve' => function (User $user, $args, $context) {
						return $user->nickname();
					},
				],
				'token' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'JWT token used for authentication in API.',
					'resolve' => function (User $user, $args, $context) {
						return $user->token();
					},
				],
			],
		]);
	}

}
