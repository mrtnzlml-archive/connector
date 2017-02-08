<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\ITokenStrategy;
use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User;
use Nette\Http\IResponse;

final class JwtOwnerService
{

	private $tokenStrategy;

	private $userRepository;

	public function __construct(ITokenStrategy $tokenStrategy, User\IUserRepository $userRepository)
	{
		$this->tokenStrategy = $tokenStrategy;
		$this->userRepository = $userRepository;
	}

	//TODO: check permissions here (e.g. is user allowed to do this action?)
	public function ownerFrom(string $jwtToken): ?Owner
	{
		try {
			$payload = $this->tokenStrategy->decodeToken($jwtToken);
			/** @var string $userId */
			$userId = $payload->uuid;
		} catch(\UnexpectedValueException $exc) {
			throw new \Adeira\Connector\Endpoints\Application\Exceptions\BubbleUpGracefullyException(
				$exc->getMessage(),
				IResponse::S401_UNAUTHORIZED
			);
		}

		$user = $this->userRepository->ofId(User\UserId::createFromString($userId));
		return $user ? new Owner($user) : NULL;
	}

	public function existingOwner(string $jwtToken): Owner
	{
		$owner = $this->ownerFrom($jwtToken);

		if ($owner === NULL) {
			throw new \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException;
		}

		return $owner;
	}

}
