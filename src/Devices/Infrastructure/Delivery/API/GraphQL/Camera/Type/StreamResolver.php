<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera\Type;

use Adeira\Connector\Devices\DomainModel\Camera\Stream;
use Nette\Http\Url;

final class StreamResolver
{

	/**
	 * @var \Nette\Http\Url
	 */
	private $streamServerUrl;

	public function __construct(Url $streamServerUrl)
	{
		$this->streamServerUrl = $streamServerUrl;
	}

	public function source(Stream $stream): string
	{
		return $stream->source();
	}

	public function hls(Stream $stream): string
	{
		$url = $this->streamServerUrl;
		$url->setPath($stream->hlsPlaylist());
		return $url->getAbsoluteUrl();
	}

}
