<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\Humidity;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\Devices\DomainModel\Temperature;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStationId,
	WeatherStationRecord,
	WeatherStationRecordId
};
use Adeira\Connector\Devices\DomainModel\Wind;
use Adeira\Connector\PhysicalUnits\Pressure\Units\Pascal;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WeatherStationRecordTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$record = new WeatherStationRecord(
			WeatherStationRecordId::create(Uuid::fromString('71f3f015-1cd3-4b98-ac65-f34c1c661d39')),
			WeatherStationId::create(Uuid::fromString('846b5741-abfe-45ba-8d9e-d5a78dbe254f')),
			new PhysicalQuantities(
				new Pressure(new Pascal(101325), new Pascal(0)), //sea level standard atmospheric pressure
				new Temperature(NULL, NULL),
				new Humidity(NULL, NULL),
				new Wind(NULL, NULL, NULL)
			)
		);

		Assert::type(WeatherStationRecordId::class, $record->id());
		Assert::same('71f3f015-1cd3-4b98-ac65-f34c1c661d39', (string)$record->id());

		Assert::type(WeatherStationId::class, $record->weatherStationId());
		Assert::same('846b5741-abfe-45ba-8d9e-d5a78dbe254f', (string)$record->weatherStationId());

		$returnedPressure = $record->pressure();
		Assert::type(Pressure::class, $returnedPressure);
		Assert::same(101325.0, $returnedPressure->absolute());
		Assert::same(0.0, $returnedPressure->relative());
	}

}

(new WeatherStationRecordTest)->run();
