<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\Camera;

use Adeira\Connector\Devices\DomainModel\Camera\StreamService;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class StreamServiceTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_that_startStream_works()
	{
		$httpClient = \Mockery::mock(\GuzzleHttp\ClientInterface::class);
		$httpClient->shouldReceive('request')->once()->withArgs([
			'POST',
			'startStream',
			[
				'form_params' => [
					'source' => 'rtps://stream.source',
				],
			],
		])->andReturn(new \GuzzleHttp\Psr7\Response(200, [], '{"data":{"id":"1"}}'));

		$response = (new StreamService($httpClient))->startStream('rtps://stream.source');
		Assert::same('1', $response);
	}

	public function test_that_stopStream_works()
	{
		$httpClient = \Mockery::mock(\GuzzleHttp\ClientInterface::class);
		$httpClient->shouldReceive('request')->once()->withArgs([
			'POST',
			'stopStream',
			[
				'form_params' => [
					'identifier' => '00000000-0000-0000-0000-000000000000',
				],
			],
		]);

		Assert::noError(function () use ($httpClient) {
			(new StreamService($httpClient))->stopStream(Uuid::fromString('00000000-0000-0000-0000-000000000000'));
		});
	}

	public function tearDown()
	{
		\Mockery::close();
	}

}

(new StreamServiceTest)->run();
