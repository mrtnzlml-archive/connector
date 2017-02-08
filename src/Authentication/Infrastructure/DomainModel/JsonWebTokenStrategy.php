<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel;

use Adeira\Connector\Authentication\DomainModel;

final class JsonWebTokenStrategy implements DomainModel\ITokenStrategy
{

	/**
	 * @var string
	 */
	private $privateJsonWebToken;

	/**
	 * Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'.
	 */
	private $allowedAlgs = 'HS512';

	public function __construct(string $privateJsonWebToken)
	{
		$this->privateJsonWebToken = $privateJsonWebToken;
	}

	public function generateNewToken(DomainModel\User\UserId $userId): string
	{
		$newPayload = [
			'iat' => time(), // Issued At
			'exp' => time() + (60 * 60), // Expiration Time (60 mins; 60 secs)
			'uuid' => $userId->id(),
		];
		return \Firebase\JWT\JWT::encode($newPayload, $this->privateJsonWebToken, $this->allowedAlgs);
	}

	public function decodeToken(string $jsonWebToken)
	{
		try {
			return \Firebase\JWT\JWT::decode($jsonWebToken, $this->privateJsonWebToken, [$this->allowedAlgs]);
		} catch (\UnexpectedValueException $exc) {
			throw new \UnexpectedValueException('Provided JWT token is not valid: ' . mb_strtolower($exc->getMessage()));
		}
	}

}
