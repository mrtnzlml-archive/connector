<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\Camera;

use Adeira\Connector\Devices\DomainModel\Camera\Stream;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class StreamTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_source()
	{
		$stream = Stream::create('rtsp://a', Uuid::uuid4(), 'hls');
		Assert::same('rtsp://a', $stream->source());
	}

	public function test_identifier()
	{
		$uuid = Uuid::uuid4();
		$stream = Stream::create('rtsp://a', $uuid, 'hls');
		Assert::same($uuid, $stream->identifier());
	}

}

(new StreamTest)->run();
