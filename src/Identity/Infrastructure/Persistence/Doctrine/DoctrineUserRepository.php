<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Identity\DomainModel;
use Doctrine\ORM;

class DoctrineUserRepository implements DomainModel\User\IUserRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	private $userRepository;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->userRepository = $em->getRepository(DomainModel\User\User::class);
	}

	public function add(DomainModel\User\User $user)
	{
		$this->em->persist($user);
	}

	public function ofId(DomainModel\User\UserId $userId)
	{
		return $this->userRepository->find($userId);
	}

	public function ofUsername(string $username)//: ?User
	{
		return $this->userRepository->findOneBy([
			'username' => $username,
		]);
	}

	public function nextIdentity(): DomainModel\User\UserId
	{
		return DomainModel\User\UserId::create();
	}

}
