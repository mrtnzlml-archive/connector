<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\DomainModel;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

interface ITokenStrategy
{

	public function generateNewToken(UserId $userId): string;

	/**
	 * This should also verify token.
	 */
	public function decodeToken(string $token);

}
