<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\DomainModel;

use Adeira\Connector\Identity\DomainModel;

class JsonWebTokenStrategy implements DomainModel\ITokenStrategy
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

	public function generateNewToken(array $payload = []): string
	{
		$newPayload = [
				'iat' => time(), // Issued At
				'exp' => time() + (60 * 60), // Expiration Time (60 mins; 60 secs)
			] + $payload;
		return \Firebase\JWT\JWT::encode($newPayload, $this->privateJsonWebToken, $this->allowedAlgs);
	}

	public function decodeToken(string $jsonWebToken)
	{
		return \Firebase\JWT\JWT::decode($jsonWebToken, $this->privateJsonWebToken, [$this->allowedAlgs]);
	}

}
