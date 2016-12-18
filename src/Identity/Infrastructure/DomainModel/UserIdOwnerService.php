<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\DomainModel;

use Adeira\Connector\Identity\DomainModel;

class UserIdOwnerService implements DomainModel\User\IOwnerService
{

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\User\IUserRepository
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
		throw new \Adeira\Connector\Inbound\Application\Exceptions\InvalidOwnerException;
	}

}
