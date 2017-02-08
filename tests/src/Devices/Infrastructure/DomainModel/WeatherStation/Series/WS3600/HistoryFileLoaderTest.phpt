<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\DomainModel\WeatherStation\Series\WS3600;

use Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Series\WS3600;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class HistoryFileLoaderTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatFirstRecordWorks()
	{
		$loader = new WS3600\HistoryFileLoader;

		$historyFile = __DIR__ . '/history.dat';
		$generator = $loader->yieldWeatherStationRecord($historyFile);
		Assert::equal([
			'timestamp' => new \DateTimeImmutable('2015-04-22T08:45:00+00:00'),
			'absPressure' => 979.5,
			'relPressure' => 1020.5,
			'windSpeed' => NULL,
			'windDirection' => NULL,
			'windGust' => NULL,
			'totalRainfall' => 0.0,
			'newRainfall' => 0.0,
			'indoorTemp' => 22.0,
			'outdoorTemp' => NULL,
			'indoorHumidity' => 32.0,
			'outdoorHumidity' => NULL,
			'__unknown' => 0,
		], $generator->current());
	}

	public function testThatItYieldsAllRecords()
	{
		$recordsCount = 0;
		$lastRecord = NULL;

		$historyFile = __DIR__ . '/history.dat';
		$generator = (new WS3600\HistoryFileLoader)->yieldWeatherStationRecord($historyFile);
		foreach ($generator as $line) {
			$recordsCount++;
			$lastRecord = $line;
		}

		Assert::same(16531, $recordsCount);

		// last record:
		Assert::equal([
			'timestamp' => new \DateTimeImmutable('2016-11-11T10:15:00+00:00'),
			'absPressure' => 966.40002441406,
			'relPressure' => 1006.4000244141,
			'windSpeed' => NULL,
			'windDirection' => NULL,
			'windGust' => NULL,
			'totalRainfall' => 0.0,
			'newRainfall' => 0.0,
			'indoorTemp' => 24.400001525879,
			'outdoorTemp' => NULL,
			'indoorHumidity' => 32.0,
			'outdoorHumidity' => NULL,
			'__unknown' => 0,
		], $lastRecord);
	}

}

(new HistoryFileLoaderTest)->run();
