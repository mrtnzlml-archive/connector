<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

final class Context
{

	private $userId;

	public function __construct(UserId $userId)
	{
		$this->userId = $userId;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

}
