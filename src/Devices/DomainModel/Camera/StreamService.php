<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Ramsey\Uuid\Uuid;
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

	public function startStream(string $streamSource): Stream
	{
		//TODO: handle exceptions (?)
		$response = $this->client->request('POST', 'startStream', [
			'form_params' => [
				'source' => $streamSource,
			],
		]);
		$data = json_decode($response->getBody()->getContents(), TRUE)['data'];
		return Stream::create($streamSource, Uuid::fromString($data['id']), $data['hls']);
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
