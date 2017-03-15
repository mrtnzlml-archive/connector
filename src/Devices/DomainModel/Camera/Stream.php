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

	/**
	 * @var string
	 */
	private $hlsPlaylist;

	private function __construct()
	{
	}

	public static function create(string $streamSource, UuidInterface $streamIdentifier, string $hlsPlaylist): self
	{
		$stream = new self;
		$stream->source = $streamSource;
		$stream->identifier = $streamIdentifier;
		$stream->hlsPlaylist = $hlsPlaylist;
		return $stream;
	}

	public function source(): string
	{
		return $this->source;
	}

	public function identifier(): UuidInterface
	{
		return $this->identifier;
	}

	public function hlsPlaylist(): string
	{
		return $this->hlsPlaylist;
	}

}
