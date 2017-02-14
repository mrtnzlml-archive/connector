<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User;

final class UserIdOwnerService
{

	private $userRepository;

	public function __construct(User\IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function existingOwner(User\UserId $userId): Owner
	{
		$owner = $this->ownerFrom($userId);

		if ($owner === NULL) {
			throw new \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException;
		}

		return $owner;
	}

	//TODO: check permissions here (e.g. is user allowed to do this action?)
	private function ownerFrom(User\UserId $userId): ?Owner
	{
		$user = $this->userRepository->ofId($userId);
		return $user ? new Owner($user) : NULL;
	}

}
