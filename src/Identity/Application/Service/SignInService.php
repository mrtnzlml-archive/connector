<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Application\Service;

use Adeira\Connector\Identity\DomainModel\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\IAuthenticator;

class SignInService
{

	/**
	 * @var \Nette\Security\IAuthenticator
	 */
	private $authenticator;

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(IAuthenticator $authenticator, EntityManagerInterface $em)
	{
		$this->authenticator = $authenticator;
		$this->em = $em;
	}

	public function execute($username, $password): User //FIXME: return DTO instead
	{
		/** @var User $user */
		$user = $this->authenticator->authenticate([
			$username,
			$password,
		]);
		$this->em->flush();
		return $user;
	}

}
