<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\DomainModel\User;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Identity.DomainModel.User.User.dcm.xml
 */
class User implements \Nette\Security\IIdentity
{

	/**
	 * @var UserId
	 */
	private $id;

	private $username;

	private $passwordHash;

	/**
	 * @var string JWT token used for authentication in API
	 */
	private $token;

	public function __construct(UserId $id, string $username)
	{
		$this->id = $id;
		$this->username = $username;
	}

	public function id(): UserId
	{
		return $this->id;
	}

	public function nickname(): string
	{
		return $this->username;
	}

	public function token(): string
	{
		return $this->token;
	}

	public function authenticate($pass, callable $checkHash, callable $generateToken): bool
	{
		$passwordCorrect = $checkHash($pass, $this->passwordHash);
		if ($passwordCorrect === TRUE) {
			$this->token = $generateToken([
				'uuid' => (string)$this->id(),
			]);
		}
		return $passwordCorrect;
	}

	public function changePass(string $pass, callable $hash)
	{
		$this->passwordHash = $hash($pass);
	}

	public function needRehash(callable $checkRehash): bool
	{
		return $checkRehash($this->passwordHash);
	}

	/**
	 * Implementation of Nette\Security\IIdentity
	 */
	final public function getId(): UserId
	{
		return $this->id;
	}

	/**
	 * Implementation of Nette\Security\IIdentity
	 */
	public function getRoles(): array
	{
		return [];
	}

	public function __clone()
	{
		$this->id = \Ramsey\Uuid\Uuid::uuid4();
	}

}
