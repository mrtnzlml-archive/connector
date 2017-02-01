<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	id, nullableString, string
};

final class UserType extends \Adeira\Connector\GraphQL\Structure\Type
{

	public function getPublicTypeName(): string
	{
		return 'User';
	}

	public function getPublicTypeDescription(): string
	{
		return 'User entity.';
	}

	public function defineFields(): array
	{
		return [
			$this->idFieldDefinition(),
			$this->usernameFieldDefinition(),
			$this->tokenFieldDefinition(),
		];
	}

	private function idFieldDefinition()
	{
		$field = new Field('id', 'ID of the User', id());
		$field->setResolveFunction(function (User $user, $args, $context) {
			return $user->id();
		});
		return $field;
	}

	private function usernameFieldDefinition()
	{
		$field = new Field('username', 'Username of the user', string());
		$field->setResolveFunction(function (User $user, $args, $context) {
			return $user->nickname();
		});
		return $field;
	}

	private function tokenFieldDefinition()
	{
		$field = new Field('token', 'JWT token used for authentication in API', nullableString());
		$field->setResolveFunction(function (User $user, $args, $context) {
			return $user->token();
		});
		return $field;
	}

}
