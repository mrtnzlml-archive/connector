<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\UI\GraphQL;

use Adeira\Connector\Identity\DomainModel\User\User;
use GraphQL\Type\Definition;

class UserType implements \Adeira\Connector\GraphQL\IType
{

	private $definition;

	/**
	 * type User {
	 *     id: String!
	 *     ...
	 * }
	 */
	public function __invoke(): Definition\ObjectType
	{
		if ($this->definition !== NULL) {
			return $this->definition;
		}
		return $this->definition = new Definition\ObjectType([
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
