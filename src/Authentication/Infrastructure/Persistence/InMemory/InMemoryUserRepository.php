<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel;
use Doctrine\Common\Collections\ArrayCollection;

final class InMemoryUserRepository implements DomainModel\User\IUserRepository
{

	private $memory;

	public function __construct()
	{
		$this->memory = new ArrayCollection;
	}

	public function add(DomainModel\User\User $user): void
	{
		$this->memory->set((string)$user->id(), $user);
	}

	public function ofId(DomainModel\User\UserId $userId): ?DomainModel\User\User
	{
		return $this->memory->get((string)$userId);
	}

	public function ofUsername(string $username): ?DomainModel\User\User
	{
		/** @var DomainModel\User\User $user */
		foreach ($this->memory as $key => $user) {
			if ($user->nickname() === $username) {
				return $user;
			}
		}
		return NULL;
	}

	public function nextIdentity(): DomainModel\User\UserId
	{
		return DomainModel\User\UserId::create();
	}

}
