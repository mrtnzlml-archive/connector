<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\User\{
	User, UserId
};

/**
 * Owner is User with permissions. This should force you to use IOwnerService.
 */
final class Owner
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\UserId
	 */
	private $id;

	private $user;

	public function __construct(User $user)
	{
		$this->id = clone $user->id();
		$this->user = clone $user;
	}

	public function id(): UserId
	{
		return $this->id;
	}

	public function nickname(): string
	{
		return $this->user->nickname();
	}

	public function __clone()
	{
		$this->id = UserId::create();
	}

}
