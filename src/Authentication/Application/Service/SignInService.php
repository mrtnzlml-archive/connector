<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Application\Service;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\Identity\DomainModel\User\User;
use Nette\Security\IAuthenticator;

class SignInService
{

	/**
	 * @var \Nette\Security\IAuthenticator
	 */
	private $authenticator;

	/**
	 * @var \Adeira\Connector\Common\Application\Service\ITransactionalSession
	 */
	private $transactionalSession;

	public function __construct(IAuthenticator $authenticator, ITransactionalSession $transactionalSession)
	{
		$this->authenticator = $authenticator;
		$this->transactionalSession = $transactionalSession;
	}

	public function execute($username, $password): User //FIXME: return DTO instead
	{
		return $this->transactionalSession->executeAtomically(function () use ($username, $password) {
			return $this->authenticator->authenticate([
				$username,
				$password,
			]);
		});
	}

}
