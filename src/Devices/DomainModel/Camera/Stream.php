<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Ramsey\Uuid\UuidInterface;

final class Stream
{

	/**
	 * @var string
	 */
	private $source;

	/**
	 * @var \Ramsey\Uuid\UuidInterface
	 */
	private $identifier;

	public function __construct(string $streamSource, UuidInterface $streamIdentifier)
	{
		$this->source = $streamSource;
		$this->identifier = $streamIdentifier;
	}

	public function source(): string
	{
		return $this->source;
	}

	public function identifier(): UuidInterface
	{
		return $this->identifier;
	}

}
