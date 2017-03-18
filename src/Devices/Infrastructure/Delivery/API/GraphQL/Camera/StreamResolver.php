<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

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

	public function hls(Stream $camera)
	{
		$url = $this->streamServerUrl;
		$url->setPath($camera->hlsPlaylist());
		return $url->getAbsoluteUrl();
	}

}
