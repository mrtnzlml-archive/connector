<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Application\Service;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\Identity\DomainModel\User\IUserRepository;
use Adeira\Connector\Identity\DomainModel\User\User;
use Nette\Security\Passwords;

class CreateUserService
{

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \Adeira\Connector\Common\Application\Service\ITransactionalSession
	 */
	private $transactionalSession;

	public function __construct(IUserRepository $userRepository, ITransactionalSession $transactionalSession)
	{
		$this->userRepository = $userRepository;
		$this->transactionalSession = $transactionalSession;
	}

	public function execute($username, $password) //TODO: DTO
	{
		$user = new User(
			$this->userRepository->nextIdentity(),
			$username
		);
		$user->changePass($password, [Passwords::class, 'hash']);

		try {
			$this->transactionalSession->executeAtomically(function () use ($user) {
				$this->userRepository->add($user);
			});
		} catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $exc) {
			throw new \Adeira\Connector\Identity\Application\Exception\DuplicateNameException($user);
		}
	}

}
