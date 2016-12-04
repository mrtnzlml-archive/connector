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
	 * @var string
	 */
	private $privateJWTkey;

	public function __construct(DomainModel\User\IUserRepository $userRepository, $privateJWTkey)
	{
		$this->userRepository = $userRepository;
		$this->privateJWTkey = $privateJWTkey;
	}

	public function authenticate(array $credentials): DomainModel\User\User
	{
		list($username, $password) = $credentials;
		$user = $this->userRepository->ofUsername($username);

		if (!$user) {
			throw new \Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		} elseif (!$user->authenticate($password, [Passwords::class, 'verify'], [$this, 'generateJsonWebToken'])) {
			throw new \Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		} elseif ($user->needRehash([Passwords::class, 'needsRehash'])) {
			$user->changePass($password, [Passwords::class, 'hash']);
			//FIXME maybe? https://github.com/doctrine/DoctrineBundle/issues/303#issuecomment-47532854
		}

		return $user;
	}

	/**
	 * This function is called during authentication from entity so it's possible to change implementation in future.
	 */
	public function generateJsonWebToken(): string
	{
		$payload = [
			'iat' => time(), // Issued At
			'exp' => time() + (60 * 60), // Expiration Time (60 mins; 60 secs)
		];
		return \Firebase\JWT\JWT::encode($payload, $this->privateJWTkey, 'HS512');
	}

}
