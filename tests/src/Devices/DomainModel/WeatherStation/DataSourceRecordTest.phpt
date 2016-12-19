<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStationId,
	WeatherStationRecord,
	WeatherStationRecordId
};
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class DataSourceRecordTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$record = new WeatherStationRecord(
			WeatherStationRecordId::create(Uuid::fromString('71f3f015-1cd3-4b98-ac65-f34c1c661d39')),
			WeatherStationId::create(Uuid::fromString('846b5741-abfe-45ba-8d9e-d5a78dbe254f')),
			[
				'data_1',
				'data_2',
			]
		);

		Assert::type(WeatherStationRecordId::class, $record->id());
		Assert::same('71f3f015-1cd3-4b98-ac65-f34c1c661d39', (string)$record->id());

		Assert::type(WeatherStationId::class, $record->weatherStationId());
		Assert::same('846b5741-abfe-45ba-8d9e-d5a78dbe254f', (string)$record->weatherStationId());

		Assert::same([
			'data_1',
			'data_2',
		], $record->data());
	}

}

(new DataSourceRecordTest)->run();
