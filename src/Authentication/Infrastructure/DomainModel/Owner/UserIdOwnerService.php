<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService;
use Adeira\Connector\Authentication\DomainModel\User;

final class UserIdOwnerService implements IOwnerService
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	public function __construct(User\IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function ownerFrom(User\UserId $userId): ?User\User
	{
		//TODO: check permissions here (e.g. is user allowed to do this action?)
		return $this->userRepository->ofId($userId);
	}

	public function throwInvalidOwnerException()
	{
		throw new \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException;
	}

}
