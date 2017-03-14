<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Ramsey\Uuid\UuidInterface;

final class StreamService
{

	/**
	 * @var \GuzzleHttp\ClientInterface
	 */
	private $client;

	public function __construct(\GuzzleHttp\ClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * @return string New stream identifier.
	 */
	public function startStream(string $streamSource): string
	{
		//TODO: handle exceptions (?)
		$response = $this->client->request('POST', 'startStream', [
			'form_params' => [
				'source' => $streamSource,
			],
		]);
		return json_decode($response->getBody()->getContents(), TRUE)['data']['id'];
	}

	public function stopStream(UuidInterface $streamIdentifier): void
	{
		$this->client->request('POST', 'stopStream', [
			'form_params' => [
				'identifier' => $streamIdentifier->toString(),
			],
		]);
	}

}
