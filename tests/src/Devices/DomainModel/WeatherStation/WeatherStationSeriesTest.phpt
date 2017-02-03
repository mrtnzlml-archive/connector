<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStationSeries, WeatherStationSeriesId
};
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WeatherStationSeriesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$series = new WeatherStationSeries(
			WeatherStationSeriesId::create(Uuid::fromString('71f3f015-0000-4b98-ac65-f34c1c661d39')),
			'WS3600'
		);

		Assert::type(WeatherStationSeriesId::class, $series->id());
		Assert::same('71f3f015-0000-4b98-ac65-f34c1c661d39', (string)$series->id());
		Assert::same('WS3600', $series->code());
	}

}

(new WeatherStationSeriesTest)->run();
