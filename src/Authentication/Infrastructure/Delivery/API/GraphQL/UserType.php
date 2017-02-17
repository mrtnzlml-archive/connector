<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\GraphQL\Context;

final class UserType
{

	public function id(User $user, $args, Context $context)
	{
		return $user->id();
	}

	public function username(User $user, $args, Context $context)
	{
		return $user->nickname();
	}

	public function token(User $user, $args, Context $context)
	{
		return $user->token();
	}

}
