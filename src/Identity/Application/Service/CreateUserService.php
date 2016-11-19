<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Application\Service;

use Adeira\Connector\Identity\DomainModel\User\IUserRepository;
use Adeira\Connector\Identity\DomainModel\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\Passwords;

class CreateUserService
{

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(IUserRepository $userRepository, EntityManagerInterface $em)
	{
		$this->userRepository = $userRepository;
		$this->em = $em;
	}

	public function execute($username, $password) //TODO: DTO
	{
		$user = new User(
			$this->userRepository->nextIdentity(),
			$username
		);
		$user->changePass($password, [Passwords::class, 'hash']);

		try {
			$this->em->transactional(function () use ($user) {
				$this->userRepository->add($user);
			});
		} catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $exc) {
			throw new \Adeira\Connector\Identity\Application\Exception\DuplicateNameException($user);
		}
	}

}
