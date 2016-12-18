<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\DomainModel;

use Adeira\Connector\Identity\DomainModel;
use Nette\Security\Passwords;

class Authenticator implements \Nette\Security\IAuthenticator
{

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\ITokenStrategy
	 */
	private $tokenStrategy;

	public function __construct(DomainModel\User\IUserRepository $userRepository, ITokenStrategy $tokenStrategy)
	{
		$this->userRepository = $userRepository;
		$this->tokenStrategy = $tokenStrategy;
	}

	public function authenticate(array $credentials): DomainModel\User\User
	{
		list($username, $password) = $credentials;
		$user = $this->userRepository->ofUsername($username);

		if (!$user) {
			throw new \Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		} elseif (!$user->authenticate($password, [Passwords::class, 'verify'], [$this->tokenStrategy, 'generateNewToken'])) {
			throw new \Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		} elseif ($user->needRehash([Passwords::class, 'needsRehash'])) {
			$user->changePass($password, [Passwords::class, 'hash']);
			//FIXME maybe? https://github.com/doctrine/DoctrineBundle/issues/303#issuecomment-47532854
		}

		return $user;
	}

}
