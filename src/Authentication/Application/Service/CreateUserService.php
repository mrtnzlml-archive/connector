<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Application\Service;

use Adeira\Connector\Authentication\DomainModel\User\IUserRepository;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Nette\Security\Passwords;

class CreateUserService
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\IUserRepository
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

	public function execute($username, $password): UserId
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
			return $user->id();
		} catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $exc) {
			throw new \Adeira\Connector\Authentication\Application\Exception\DuplicateUsernameException($user);
		}
	}

}
