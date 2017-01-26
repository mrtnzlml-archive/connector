<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel;

final class UserIdOwnerService implements DomainModel\Owner\IOwnerService
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	public function __construct(DomainModel\User\IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function ownerFrom(DomainModel\User\UserId $userId)
	{
		//TODO: check permissions here (e.g. is user allowed to do this action?)
		return $this->userRepository->ofId($userId);
	}

	public function throwInvalidOwnerException()
	{
		throw new \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException;
	}

}
